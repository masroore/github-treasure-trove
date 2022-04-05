<?php

/**
 * Copyright 2018 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

//namespace Google\Ads\GoogleAds\Examples\Planning;

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';
use App\Models\KeywordIdea;
use App\Models\User;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Ads\GoogleAds\Lib\V8\GoogleAdsClient;
use Google\Ads\GoogleAds\Lib\V8\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\Lib\V8\GoogleAdsException;
use Google\Ads\GoogleAds\Util\V8\ResourceNames;
use Google\Ads\GoogleAds\V8\Enums\KeywordPlanNetworkEnum\KeywordPlanNetwork;
use Google\Ads\GoogleAds\V8\Errors\GoogleAdsError;
use Google\Ads\GoogleAds\V8\Services\GenerateKeywordIdeaResult;
use Google\Ads\GoogleAds\V8\Services\KeywordAndUrlSeed;
use Google\Ads\GoogleAds\V8\Services\KeywordSeed;
use Google\Ads\GoogleAds\V8\Services\UrlSeed;
use Google\ApiCore\ApiException;
use Illuminate\Http\Request;
use stdClass;

/** This example generates keyword ideas from a list of seed keywords or a seed page URL. */
class GenerateKeywordIdeas extends Controller
{
    public static function main(Request $request): void
    {
        // Either pass the required parameters for this example on the command line, or insert them
        // into the constants above.
        $customerId = 5121970149;
        $locationIds = [20160, 20154];
        $languageId = 1003;
        $keywords = [$request->words];
        $pageUrl = null;
        $b_id = $request->b_id;

        // Generate a refreshable OAuth2 credential for authentication.
        $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile()->build();

        // Construct a Google Ads client configured from a properties file and the
        // OAuth2 credentials above.
        $googleAdsClient = (new GoogleAdsClientBuilder())->fromFile()
            ->withOAuth2Credential($oAuth2Credential)
            ->build();

        try {
            self::runExample(
                $googleAdsClient,
                $customerId,
                $locationIds,
                $languageId,
                $keywords,
                $pageUrl,
                $b_id
            );
        } catch (GoogleAdsException $googleAdsException) {
            printf(
                "Request with ID '%s' has failed.%sGoogle Ads failure details:%s",
                $googleAdsException->getRequestId(),
                PHP_EOL,
                PHP_EOL
            );
            foreach ($googleAdsException->getGoogleAdsFailure()->getErrors() as $error) {
                /** @var GoogleAdsError $error */
                printf(
                    "\t%s: %s%s",
                    $error->getErrorCode()->getErrorCode(),
                    $error->getMessage(),
                    PHP_EOL
                );
            }
            exit(1);
        } catch (ApiException $apiException) {
            printf(
                "ApiException was thrown with message '%s'.%s",
                $apiException->getMessage(),
                PHP_EOL
            );
            exit(1);
        }
    }

    /**
     * Runs the example.
     *
     * @param GoogleAdsClient $googleAdsClient the Google Ads API client
     * @param int $customerId the customer ID
     * @param int[] $locationIds the location IDs
     * @param int $languageId the language ID
     * @param string[] $keywords the list of keywords to use as a seed for ideas
     * @param null|string $pageUrl optional URL related to your business to use as a seed for ideas
     */
    // [START generate_keyword_ideas]
    public static function runExample(
        GoogleAdsClient $googleAdsClient,
        int $customerId,
        array $locationIds,
        int $languageId,
        array $keywords,
        ?string $pageUrl,
        int $b_id
    ): void {
        $keywordPlanIdeaServiceClient = $googleAdsClient->getKeywordPlanIdeaServiceClient();

        // Make sure that keywords and/or page URL were specified. The request must have exactly one
        // of urlSeed, keywordSeed, or keywordAndUrlSeed set.
        if (empty($keywords) && null === $pageUrl) {
            throw new \InvalidArgumentException(
                'At least one of keywords or page URL is required, but neither was specified.'
            );
        }

        // Specify the optional arguments of the request as a keywordSeed, urlSeed,
        // or keywordAndUrlSeed.
        $requestOptionalArgs = [];
        if (empty($keywords)) {
            // Only page URL was specified, so use a UrlSeed.
            $requestOptionalArgs['urlSeed'] = new UrlSeed(['url' => $pageUrl]);
        } elseif (null === $pageUrl) {
            // Only keywords were specified, so use a KeywordSeed.
            $requestOptionalArgs['keywordSeed'] = new KeywordSeed(['keywords' => $keywords]);
        } else {
            // Both page URL and keywords were specified, so use a KeywordAndUrlSeed.
            $requestOptionalArgs['keywordAndUrlSeed'] =
                new KeywordAndUrlSeed(['url' => $pageUrl, 'keywords' => $keywords]);
        }

        // Create a list of geo target constants based on the resource name of specified location
        // IDs.
        $geoTargetConstants = array_map(function ($locationId) {
            return ResourceNames::forGeoTargetConstant($locationId);
        }, $locationIds);

        // Generate keyword ideas based on the specified parameters.
        $response = $keywordPlanIdeaServiceClient->generateKeywordIdeas(
            [
                // Set the language resource using the provided language ID.
                'language' => ResourceNames::forLanguageConstant($languageId),
                'customerId' => $customerId,
                // Add the resource name of each location ID to the request.
                'geoTargetConstants' => $geoTargetConstants,
                // Set the network. To restrict to only Google Search, change the parameter below to
                // KeywordPlanNetwork::GOOGLE_SEARCH.
                'keywordPlanNetwork' => KeywordPlanNetwork::GOOGLE_SEARCH_AND_PARTNERS,
            ] + $requestOptionalArgs
        );

        $kw_array = [];

        // Iterate over the results and print its detail.
        foreach ($response->iterateAllElements() as $result) {
            /** @var GenerateKeywordIdeaResult $result */
            // Note that the competition printed below is enum value.
            // For example, a value of 2 will be returned when the competition is 'LOW'.
            // A mapping of enum names to values can be found at KeywordPlanCompetitionLevel.php.
            /*
            printf(
                "Keyword idea text '%s' has %d average monthly searches and competition as %d.%s",
                $result->getText(),
                is_null($result->getKeywordIdeaMetrics()) ?
                    0 : $result->getKeywordIdeaMetrics()->getAvgMonthlySearches(),
                is_null($result->getKeywordIdeaMetrics()) ?
                    0 : $result->getKeywordIdeaMetrics()->getCompetition(),
                PHP_EOL
            );
            */
            $current_kw = new stdClass();
            $current_kw->keywords = $result->getText();
            null === $result->getKeywordIdeaMetrics() ?
                $current_kw->monthly_searches = 0 : $current_kw->monthly_searches = $result->getKeywordIdeaMetrics()->getAvgMonthlySearches();
            null === $result->getKeywordIdeaMetrics() ?
                $current_kw->competition = 0 : $current_kw->competition = $result->getKeywordIdeaMetrics()->getCompetition();

            $kw_array[] = $current_kw;
        }
        $json = json_encode($kw_array);
        //echo $json;
        $db_element = new KeywordIdea();
        $db_element->json_output = $json;
        $db_element->busqueda_id = $b_id;
        $db_element->save();
        //return ($json);
    }
    // [END generate_keyword_ideas]

    //Public Onboarding Birs Request
    public static function SZTg2FkeozJAJPebUOCW(Request $request)
    {
        if (User::where('email', $request->email)->first()) {
            $email_exists = true;

            return view('successonboarding', compact('email_exists'));
        }
        $MIqjjOCc6 = 5121970149;
        $osbn4NS73BS = [20160, 20154];
        $JNubs73 = 1003;
        $hnsb83B = [$request->c1, $request->c2, $request->c3];
        $KASjsb7 = null;
        $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile()->build();
        $nmlss = (new GoogleAdsClientBuilder())->fromFile()->withOAuth2Credential($oAuth2Credential)->build();

        try {
            $final_return = [];
            $final_concepts = ucfirst($request->c1) . ', ' . ucfirst($request->c2) . ', ' . ucfirst($request->c3);
            foreach ($hnsb83B as $current_kw) {
                $current_section = new stdClass();
                $current_section->concept = $current_kw;
                $current_section->keyword_ideas = self::KnCcKnkoldDnWTlYKr5v($nmlss, $MIqjjOCc6, $osbn4NS73BS, $JNubs73, [$current_kw], $KASjsb7);
                $final_return[] = $current_section;
                sleep(3);
            }
            $final_json = json_encode($final_return);
            $url_base = env('APP_URL');
            $user_data = new Request();
            $user_data->name = $request->nombreUsuario;
            $user_data->email = $request->email;
            $user_data->telefono = $request->telefono;
            $user_data->empresa = $request->empresa;

            $reg_controller = resolve('App\Http\Controllers\RegController');
            $uid = $reg_controller->registro_onboarding($user_data);
            $nombre_campania = $request->nombre_campania;

            return view('concepts', compact('final_return', 'final_concepts', 'url_base', 'uid', 'nombre_campania'));
        } catch (GoogleAdsException $googleAdsException) {
            $from = 'sergio.aslacker@gmail.com';
            $to = 'sergio@andestic.com';
            $subject = 'Error de Google Ads';
            $headers = 'From:' . $from;
            $message = 'Nombre: ' + $request->nombreUsuario + "\nE-mail: " + $request->email + "\nTelefono: " + $request->telefono + 'Empresa: ' + $request->empresa;
            $message += "\n" + 'Request with ID ' + $googleAdsException->getRequestId() + ' has failed';
            //printf("Request with ID '%s' has failed.%sGoogle Ads failure details:%s",$googleAdsException->getRequestId(),PHP_EOL,PHP_EOL);
            foreach ($googleAdsException->getGoogleAdsFailure()->getErrors() as $error) {
                /** @var GoogleAdsError $error */
                //printf("\t%s: %s%s",$error->getErrorCode()->getErrorCode(),$error->getMessage(),PHP_EOL);
                $message += "\n" + $error->getMessage();
            }
            mail($to, $subject, $message, $headers);
            exit(1);
        } catch (ApiException $apiException) {
            printf("ApiException was thrown with message '%s'.%s", $apiException->getMessage(), PHP_EOL);
            exit(1);
        }
    }

    /**
     * Runs the example.
     *
     * @param GoogleAdsClient $googleAdsClient the Google Ads API client
     * @param int $customerId the customer ID
     * @param int[] $locationIds the location IDs
     * @param int $languageId the language ID
     * @param string[] $keywords the list of keywords to use as a seed for ideas
     * @param null|string $pageUrl optional URL related to your business to use as a seed for ideas
     */
    // [START generate_keyword_ideas]
    public static function KnCcKnkoldDnWTlYKr5v(
        GoogleAdsClient $googleAdsClient,
        int $customerId,
        array $locationIds,
        int $languageId,
        array $keywords,
        ?string $pageUrl
    ) {
        $keywordPlanIdeaServiceClient = $googleAdsClient->getKeywordPlanIdeaServiceClient();
        if (empty($keywords) && null === $pageUrl) {
            throw new \InvalidArgumentException(
                'At least one of keywords or page URL is required, but neither was specified.'
            );
        }
        $requestOptionalArgs = [];
        if (empty($keywords)) {
            $requestOptionalArgs['urlSeed'] = new UrlSeed(['url' => $pageUrl]);
        } elseif (null === $pageUrl) {
            $requestOptionalArgs['keywordSeed'] = new KeywordSeed(['keywords' => $keywords]);
        } else {
            $requestOptionalArgs['keywordAndUrlSeed'] =
                new KeywordAndUrlSeed(['url' => $pageUrl, 'keywords' => $keywords]);
        }
        $geoTargetConstants = array_map(function ($locationId) {
            return ResourceNames::forGeoTargetConstant($locationId);
        }, $locationIds);
        $response = $keywordPlanIdeaServiceClient->generateKeywordIdeas(
            [
                'language' => ResourceNames::forLanguageConstant($languageId),
                'customerId' => $customerId,
                'geoTargetConstants' => $geoTargetConstants,
                'keywordPlanNetwork' => KeywordPlanNetwork::GOOGLE_SEARCH_AND_PARTNERS,
            ] + $requestOptionalArgs
        );

        $kw_array = [];
        foreach ($response->iterateAllElements() as $result) {
            /** @var GenerateKeywordIdeaResult $result */
            $current_kw = new stdClass();
            $current_kw->keywords = $result->getText();
            null === $result->getKeywordIdeaMetrics() ?
                $current_kw->monthly_searches = 0 : $current_kw->monthly_searches = $result->getKeywordIdeaMetrics()->getAvgMonthlySearches();
            null === $result->getKeywordIdeaMetrics() ?
                $current_kw->competition = 0 : $current_kw->competition = $result->getKeywordIdeaMetrics()->getCompetition();

            $kw_array[] = $current_kw;
        }
        $json = json_encode($kw_array);
        //echo $json;
        //$db_element = new KeywordIdea;
        //$db_element->json_output = $json;
        //$db_element->busqueda_id = $b_id;
        //$db_element->save();
        //return ($kw_array);
        return array_slice($kw_array, 0, 10);
    }

    //Status
    public static function status(Request $request): void
    {
        // Either pass the required parameters for this example on the command line, or insert them
        // into the constants above.
        $customerId = 5121970149;
        $locationIds = [20160, 20154];
        $languageId = 1003;
        $keywords = ['status'];
        $pageUrl = null;

        // Generate a refreshable OAuth2 credential for authentication.
        $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile()->build();

        // Construct a Google Ads client configured from a properties file and the
        // OAuth2 credentials above.
        $googleAdsClient = (new GoogleAdsClientBuilder())->fromFile()
            ->withOAuth2Credential($oAuth2Credential)
            ->build();

        try {
            self::runStatus(
                $googleAdsClient,
                $customerId,
                $locationIds,
                $languageId,
                $keywords,
                $pageUrl,
            );
        } catch (GoogleAdsException $googleAdsException) {
            printf(
                "Request with ID '%s' has failed.%sGoogle Ads failure details:%s",
                $googleAdsException->getRequestId(),
                PHP_EOL,
                PHP_EOL
            );
            foreach ($googleAdsException->getGoogleAdsFailure()->getErrors() as $error) {
                /** @var GoogleAdsError $error */
                printf(
                    "\t%s: %s%s",
                    $error->getErrorCode()->getErrorCode(),
                    $error->getMessage(),
                    PHP_EOL
                );
            }
            exit(1);
        } catch (ApiException $apiException) {
            printf(
                "ApiException was thrown with message '%s'.%s",
                $apiException->getMessage(),
                PHP_EOL
            );
            exit(1);
        }
    }

    /**
     * Runs the example.
     *
     * @param GoogleAdsClient $googleAdsClient the Google Ads API client
     * @param int $customerId the customer ID
     * @param int[] $locationIds the location IDs
     * @param int $languageId the language ID
     * @param string[] $keywords the list of keywords to use as a seed for ideas
     * @param null|string $pageUrl optional URL related to your business to use as a seed for ideas
     */
    // [START generate_keyword_ideas]
    public static function runStatus(
        GoogleAdsClient $googleAdsClient,
        int $customerId,
        array $locationIds,
        int $languageId,
        array $keywords,
        ?string $pageUrl,
    ) {
        $keywordPlanIdeaServiceClient = $googleAdsClient->getKeywordPlanIdeaServiceClient();

        // Make sure that keywords and/or page URL were specified. The request must have exactly one
        // of urlSeed, keywordSeed, or keywordAndUrlSeed set.
        if (empty($keywords) && null === $pageUrl) {
            throw new \InvalidArgumentException(
                'At least one of keywords or page URL is required, but neither was specified.'
            );
        }

        // Specify the optional arguments of the request as a keywordSeed, urlSeed,
        // or keywordAndUrlSeed.
        $requestOptionalArgs = [];
        if (empty($keywords)) {
            // Only page URL was specified, so use a UrlSeed.
            $requestOptionalArgs['urlSeed'] = new UrlSeed(['url' => $pageUrl]);
        } elseif (null === $pageUrl) {
            // Only keywords were specified, so use a KeywordSeed.
            $requestOptionalArgs['keywordSeed'] = new KeywordSeed(['keywords' => $keywords]);
        } else {
            // Both page URL and keywords were specified, so use a KeywordAndUrlSeed.
            $requestOptionalArgs['keywordAndUrlSeed'] =
                new KeywordAndUrlSeed(['url' => $pageUrl, 'keywords' => $keywords]);
        }

        // Create a list of geo target constants based on the resource name of specified location
        // IDs.
        $geoTargetConstants = array_map(function ($locationId) {
            return ResourceNames::forGeoTargetConstant($locationId);
        }, $locationIds);

        // Generate keyword ideas based on the specified parameters.
        $response = $keywordPlanIdeaServiceClient->generateKeywordIdeas(
            [
                // Set the language resource using the provided language ID.
                'language' => ResourceNames::forLanguageConstant($languageId),
                'customerId' => $customerId,
                // Add the resource name of each location ID to the request.
                'geoTargetConstants' => $geoTargetConstants,
                // Set the network. To restrict to only Google Search, change the parameter below to
                // KeywordPlanNetwork::GOOGLE_SEARCH.
                'keywordPlanNetwork' => KeywordPlanNetwork::GOOGLE_SEARCH_AND_PARTNERS,
            ] + $requestOptionalArgs
        );

        $kw_array = [];

        // Iterate over the results and print its detail.
        foreach ($response->iterateAllElements() as $result) {
            /** @var GenerateKeywordIdeaResult $result */
            // Note that the competition printed below is enum value.
            // For example, a value of 2 will be returned when the competition is 'LOW'.
            // A mapping of enum names to values can be found at KeywordPlanCompetitionLevel.php.
            /*
            printf(
                "Keyword idea text '%s' has %d average monthly searches and competition as %d.%s",
                $result->getText(),
                is_null($result->getKeywordIdeaMetrics()) ?
                    0 : $result->getKeywordIdeaMetrics()->getAvgMonthlySearches(),
                is_null($result->getKeywordIdeaMetrics()) ?
                    0 : $result->getKeywordIdeaMetrics()->getCompetition(),
                PHP_EOL
            );
            */
            $current_kw = new stdClass();
            $current_kw->keywords = $result->getText();
            null === $result->getKeywordIdeaMetrics() ?
                $current_kw->monthly_searches = 0 : $current_kw->monthly_searches = $result->getKeywordIdeaMetrics()->getAvgMonthlySearches();
            null === $result->getKeywordIdeaMetrics() ?
                $current_kw->competition = 0 : $current_kw->competition = $result->getKeywordIdeaMetrics()->getCompetition();

            $kw_array[] = $current_kw;
        }
        $json = json_encode($kw_array);

        return $json;
    }
    // [END generate_keyword_ideas]
}

class ArgumentParser
{
    /**
     * Parses any arguments specified via the command line. For those in the provided argument
     * names that are not passed, provides null values instead.
     *
     * @param array $argumentNames the associative array of argument names to their types
     *
     * @return array the argument names to their values
     */
    public function parseCommandArguments(array $argumentNames)
    {
        $getOpt = new GetOpt();
        $normalizedOptions = [];
        $numRequiredArguments = 0;
        $getOpt->addOption(['h', 'help', GetOpt::NO_ARGUMENT, 'Show this help and quit']);
        foreach ($argumentNames as $argumentName => $argumentType) {
            $normalizedOptions[$argumentName] = null;
            // Adds an option for an argument using a long option name only.
            $getOpt->addOption(
                [
                    null,
                    $argumentName,
                    $argumentType,
                    ArgumentNames::$ARGUMENTS_TO_DESCRIPTIONS[$argumentName],
                ]
            );

            if ($argumentType === GetOpt::REQUIRED_ARGUMENT) {
                ++$numRequiredArguments;
            }
        }

        // Parse arguments and catch exceptions.
        try {
            $getOpt->process();
        } catch (ArgumentException $exception) {
            // When there are any errors regarding arguments, such as invalid argument names, or
            // specifying required arguments but not providing values, 'ArgumentException' will
            // be thrown. Show the help text in these cases.
            echo PHP_EOL . $getOpt->getHelpText();

            throw $exception;
        }
        // Show help text when requested.
        if (null !== $getOpt->getOption('help')) {
            $this->printHelpMessageAndExit($getOpt);
            // Help text is printed, so no arguments are passed. The below line is reached only
            // in tests.
            return [];
        }

        $numPassedRequiredArguments = 0;
        foreach ($getOpt->getOptions() as $optionName => $optionValue) {
            if ($argumentNames[$optionName] === GetOpt::REQUIRED_ARGUMENT) {
                ++$numPassedRequiredArguments;
            }
            $normalizedOptions[$optionName] = $optionValue;
        }
        // Don't allow the case when optional arguments are passed, but required arguments are not.
        if (
            count($getOpt->getOptions()) > 0
            && $numPassedRequiredArguments !== $numRequiredArguments
        ) {
            echo PHP_EOL . $getOpt->getHelpText();

            throw new InvalidArgumentException(
                'All required arguments must be specified.' . PHP_EOL
            );
        }

        return $normalizedOptions;
    }

    /**
     * Print the help message and exit the program.
     *
     * @param GetOpt $getOpt the GetOpt object to print its help text
     */
    public function printHelpMessageAndExit(GetOpt $getOpt): void
    {
        echo PHP_EOL . $getOpt->getHelpText();
        exit;
    }
}
class ArgumentNames
{
    public const ACCESS_ROLE = 'accessRole';
    public const ADJUSTMENT_DATE_TIME = 'adjustmentDateTime';
    public const ADJUSTMENT_TYPE = 'adjustmentType';
    public const ADVERTISER_UPLOAD_DATE_TIME = 'advertiserUploadDateTime';
    public const AD_ID = 'adId';
    public const AD_GROUP_ID = 'adGroupId';
    public const AD_GROUP_IDS = 'adGroupIds';
    public const ARTIFACT_NAME = 'artifactName';
    public const ATTRIBUTE_VALUE = 'attributeValue';
    public const BASE_CAMPAIGN_ID = 'baseCampaignId';
    public const BID_MODIFIER_VALUE = 'bidModifierValue';
    public const BILLING_SETUP_ID = 'billingSetupId';
    public const BRIDGE_MAP_VERSION_ID = 'bridgeMapVersionId';
    public const BUSINESS_ACCOUNT_IDENTIFIER = 'businessAccountIdentifier';
    public const BUSINESS_LOCATION_ID = 'businessLocationId';
    public const BUSINESS_NAME = 'businessName';
    public const CALL_START_DATE_TIME = 'callStartDateTime';
    public const CALLER_ID = 'callerId';
    public const CALLOUT_TEXT = 'calloutText';
    public const CAMPAIGN_BUDGET_ID = 'campaignBudgetId';
    public const CAMPAIGN_EXPERIMENT_ID = 'campaignExperimentId';
    public const CAMPAIGN_ID = 'campaignId';
    public const CAMPAIGN_IDS = 'campaignIds';
    public const CARRIER_COUNTRY_CODE = 'carrierCountryCode';
    public const CHAIN_ID = 'chainId';
    public const CHECK_IN_DAY_CRITERION_ID = 'checkInDayCriterionId';
    public const CONVERSION_ACTION_ID = 'conversionActionId';
    public const CONVERSION_ACTION_IDS = 'conversionActionIds';
    public const CONVERSION_CUSTOM_VARIABLE_ID = 'conversionCustomVariableId';
    public const CONVERSION_CUSTOM_VARIABLE_VALUE = 'conversionCustomVariableValue';
    public const CONVERSION_DATE_TIME = 'conversionDateTime';
    public const CONVERSION_RATE_MODIFIER = 'conversionRateModifier';
    public const CONVERSION_VALUE = 'conversionValue';
    public const COUNTRY_CODE = 'countryCode';
    public const CPC_BID_CEILING_MICRO_AMOUNT = 'cpcBidCeilingMicroAmount';
    public const CPC_BID_MICRO_AMOUNT = 'cpcBidMicroAmount';
    public const CRITERION_ID = 'criterionId';
    public const CUSTOMER_ID = 'customerId';
    public const CUSTOM_KEY = 'customKey';
    public const DRAFT_ID = 'draftId';
    public const EMAIL_ADDRESS = 'emailAddress';
    public const END_DATE_TIME = 'endDateTime';
    public const EXTERNAL_ID = 'externalId';
    public const FEED_ID = 'feedId';
    public const FEED_ITEM_ID = 'feedItemId';
    public const FEED_ITEM_IDS = 'feedItemIds';
    public const FEED_ITEM_SET_ID = 'feedItemSetId';
    public const FLIGHT_PLACEHOLDER_FIELD_NAME = 'flightPlaceholderFieldName';
    public const GCLID = 'gclid';
    public const GEO_TARGET_CONSTANT_ID = 'geoTargetConstantId';
    public const GMB_ACCESS_TOKEN = 'gmbAccessToken';
    public const GMB_EMAIL_ADDRESS = 'gmbEmailAddress';
    public const HOTEL_CENTER_ACCOUNT_ID = 'hotelCenterAccountId';
    public const IMAGE_ASSET_ID = 'imageAssetId';
    public const ITEM_ID = 'itemId';
    public const KEYWORD_PLAN_ID = 'keywordPlanId';
    public const KEYWORD_TEXT = 'keywordText';
    public const KEYWORD_TEXTS = 'keywordTexts';
    public const LABEL_ID = 'labelId';
    public const LANGUAGE_CODE = 'languageCode';
    public const LANGUAGE_ID = 'languageId';
    public const LANGUAGE_NAME = 'languageName';
    public const LOCALE = 'locale';
    public const LOCATION_ID = 'locationId';
    public const LOCATION_IDS = 'locationIds';
    public const LOCATION_NAMES = 'locationNames';
    public const LOGIN_CUSTOMER_ID = 'loginCustomerId';
    public const MANAGER_CUSTOMER_ID = 'managerCustomerId';
    public const MARKETING_IMAGE_ASSET_ID = 'marketingImageAssetId';
    public const MERCHANT_CENTER_ACCOUNT_ID = 'merchantCenterAccountId';
    public const OFFLINE_USER_DATA_JOB_TYPE = 'offlineUserDataJobType';
    public const OUTPUT_FILE_PATH = 'outputFilePath';
    public const PAGE_URL = 'pageUrl';
    public const PARTNER_ID = 'partnerId';
    public const PAYMENTS_ACCOUNT_ID = 'paymentsAccountId';
    public const PAYMENTS_PROFILE_ID = 'paymentsProfileId';
    public const PERCENT_CPC_BID_MICRO_AMOUNT = 'percentCpcBidMicroAmount';
    public const RECOMMENDATION_ID = 'recommendationId';
    public const RESTATEMENT_VALUE = 'restatementValue';
    public const CREATE_DEFAULT_LISTING_GROUP = 'createDefaultListingGroup';
    public const DELETE_EXISTING_FEEDS = 'deleteExistingFeeds';
    public const REPLACE_EXISTING_TREE = 'replaceExistingTree';
    public const QUANTITY = 'quantity';
    public const SITELINK_TEXT = 'sitelinkText';
    public const SQUARE_MARKETING_IMAGE_ASSET_ID = 'squareMarketingImageAssetId';
    public const START_DATE_TIME = 'startDateTime';
    public const USER_LIST_ID = 'userListId';
    public const USER_LIST_IDS = 'userListIds';

    public static $ARGUMENTS_TO_DESCRIPTIONS = [
        self::ACCESS_ROLE => 'The user access role',
        self::ADJUSTMENT_DATE_TIME => 'The adjustment date time',
        self::ADJUSTMENT_TYPE => 'The adjustment type',
        self::ADVERTISER_UPLOAD_DATE_TIME => 'The advertiser upload date time',
        self::AD_ID => 'The ad ID',
        self::AD_GROUP_ID => 'The ad group ID',
        self::AD_GROUP_IDS => 'The ad group IDs',
        self::ARTIFACT_NAME => 'The artifact name',
        self::ATTRIBUTE_VALUE => 'The attribute value',
        self::BASE_CAMPAIGN_ID => 'The base campaign ID',
        self::BID_MODIFIER_VALUE => 'The bid modifier value',
        self::BILLING_SETUP_ID => 'The billing setup ID',
        self::BRIDGE_MAP_VERSION_ID => 'The version of partner IDs to be used for store-sale uploads',
        self::BUSINESS_ACCOUNT_IDENTIFIER => 'The account number of the GMB account',
        self::BUSINESS_LOCATION_ID => 'The GMB location ID',
        self::BUSINESS_NAME => 'The GMB business name',
        self::CALL_START_DATE_TIME => 'The call start date time',
        self::CALLER_ID => 'The caller ID',
        self::CALLOUT_TEXT => 'The callout text',
        self::CAMPAIGN_BUDGET_ID => 'The campaign budget ID',
        self::CAMPAIGN_EXPERIMENT_ID => 'The campaign experiment ID',
        self::CAMPAIGN_ID => 'The campaign ID',
        self::CAMPAIGN_IDS => 'The campaign IDs',
        self::CARRIER_COUNTRY_CODE => 'The carrier country code',
        self::CHAIN_ID => 'The retail chain ID',
        self::CHECK_IN_DAY_CRITERION_ID => 'The hotel check-in day criterion ID',
        self::CONVERSION_ACTION_ID => 'The conversion action ID',
        self::CONVERSION_ACTION_IDS => 'The conversion action IDs',
        self::CONVERSION_CUSTOM_VARIABLE_ID => 'The conversion custom variable ID',
        self::CONVERSION_CUSTOM_VARIABLE_VALUE => 'The conversion custom variable value',
        self::CONVERSION_DATE_TIME => 'The conversion date time',
        self::CONVERSION_RATE_MODIFIER => 'The conversion rate modifier',
        self::CONVERSION_VALUE => 'The conversion value',
        self::COUNTRY_CODE => 'The country code',
        self::CPC_BID_CEILING_MICRO_AMOUNT => 'The CPC bid ceiling micro amount',
        self::CPC_BID_MICRO_AMOUNT => 'The CPC bid micro amount',
        self::CRITERION_ID => 'The criterion ID',
        self::CUSTOMER_ID => 'The customer ID without dashes',
        self::CUSTOM_KEY => 'The custom key',
        self::DRAFT_ID => 'The draft ID',
        self::EMAIL_ADDRESS => 'The email address',
        self::END_DATE_TIME => 'The end date time',
        self::EXTERNAL_ID => 'The external ID',
        self::FEED_ID => 'The feed ID',
        self::FEED_ITEM_ID => 'The feed item ID',
        self::FEED_ITEM_IDS => 'The feed item IDs',
        self::FEED_ITEM_SET_ID => 'The feed item set ID',
        self::FLIGHT_PLACEHOLDER_FIELD_NAME => 'The flight placeholder field name',
        self::GCLID => 'The Google Click ID',
        self::GEO_TARGET_CONSTANT_ID => 'The geo target constant ID',
        self::GMB_ACCESS_TOKEN => 'The access token used for uploading GMB location feed data',
        self::GMB_EMAIL_ADDRESS => 'The email address associated with the GMB account',
        self::HOTEL_CENTER_ACCOUNT_ID => 'The hotel center account ID',
        self::IMAGE_ASSET_ID => 'The image asset ID',
        self::ITEM_ID => 'The item ID',
        self::KEYWORD_PLAN_ID => 'The keyword plan ID',
        self::KEYWORD_TEXT => 'The keyword text',
        self::KEYWORD_TEXTS => 'The list of keyword texts',
        self::LABEL_ID => 'The label ID',
        self::LANGUAGE_CODE => 'The language code',
        self::LANGUAGE_ID => 'The language ID',
        self::LANGUAGE_NAME => 'The language name',
        self::LOCALE => 'The locale',
        self::LOCATION_ID => 'The location ID',
        self::LOCATION_IDS => 'The list of location IDs',
        self::LOCATION_NAMES => 'The list of location names',
        self::LOGIN_CUSTOMER_ID => 'The login customer ID',
        self::MANAGER_CUSTOMER_ID => 'The manager customer ID',
        self::MARKETING_IMAGE_ASSET_ID => 'The ID of marketing image asset',
        self::MERCHANT_CENTER_ACCOUNT_ID => 'The Merchant center account ID',
        self::OFFLINE_USER_DATA_JOB_TYPE => 'The offline user data job type',
        self::OUTPUT_FILE_PATH => 'The output file path',
        self::PAGE_URL => 'The page URL',
        self::PARTNER_ID => 'The partner ID',
        self::PAYMENTS_ACCOUNT_ID => 'The payments account ID',
        self::PAYMENTS_PROFILE_ID => 'The payments profile ID',
        self::PERCENT_CPC_BID_MICRO_AMOUNT => 'The CPC bid micro amount for the Percent CPC bidding strategy',
        self::RECOMMENDATION_ID => 'The recommendation ID',
        self::RESTATEMENT_VALUE => 'The restatement value',
        self::CREATE_DEFAULT_LISTING_GROUP => 'Whether it should create a default listing group',
        self::DELETE_EXISTING_FEEDS => 'Whether it should delete the existing feeds',
        self::REPLACE_EXISTING_TREE => 'Whether it should replace the existing listing group tree on an ad group',
        self::QUANTITY => 'The quantity',
        self::SITELINK_TEXT => 'The sitelink text',
        self::SQUARE_MARKETING_IMAGE_ASSET_ID => 'The ID of square marketing image asset',
        self::START_DATE_TIME => 'The start date time',
        self::USER_LIST_ID => 'The user list ID',
        self::USER_LIST_IDS => 'The user list IDs',
    ];
}
