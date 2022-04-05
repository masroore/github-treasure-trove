<?php

namespace App\Http\Controllers;

use App\Helpers\Encryptor;
use App\Models\Account;
use App\Models\Activity;
use App\Models\Bank;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ClientPos;
use App\Models\ClientPosTransaction;
use App\Models\ClientRepresentative;
use App\Models\CoinTransaction;
use App\Models\Commerce;
use App\Models\Country;
use App\Models\EconomicActivity;
use App\Models\EconomicSector;
use App\Models\Franchise;
use App\Models\Gender;
use App\Models\Miscellaneous;
use App\Models\Modality;
use App\Models\Municipality;
use App\Models\Nationality;
use App\Models\Operative;
use App\Models\Person;
use App\Models\PostalCode;
use App\Models\Product;
use App\Models\Representative;
use App\Models\State;
use App\Models\Storage;
use App\Models\TelephoneOperator;
use App\Models\TypeAccount;
use App\Models\TypeDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Validator;

class ClientController extends Controller
{
    protected $type_client_natural = 1; //type of client natural

    protected $type_client_juridic = 2; //type of client juridic

    protected $type_representative_legal = 1; // type of representative legal

    protected $type_representative_commerce = 2; // type of representative of commerce

    protected $social_network_facebook = 1;

    protected $social_network_instagram = 2;

    protected $social_network_twitter = 3;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Request::ajax()) {
            $type_document = TypeDocument::pluck('abbreviation', 'id');
            $operative = Operative::where('status', 1)->pluck('name_operative', 'id');
            $storage = [];
            $listStorageUser = $this->getUserStorages();

            foreach (Storage::where('status', 1)->whereIn('id', $listStorageUser)->get()->toARray() as $value) {
                $storage[$value['id']] = $value['type_storage']['description'] . ': ' . $value['name_storage'];
            }

            return view('client.client_index', compact('type_document', 'operative', 'storage'));
        }

        return Redirect::to('home');
    }

    public function getDataClient(Request $request)
    {

        if ($request->type != null) {
            if ($request->type == 'code') {
                $validator = Validator::make($request->all(), [
                    'code' => 'required',
                ]);
                if ($validator->fails()) {
                    $result['status'] = 0;
                    $result['title'] = __('');
                    $result['message'] = __('Wrong Data');
                    $result['type_message'] = 'error';
                } else {
                    $client = $this->getClient($request->code);
                    $code_account = [];
                    if ($client == null) {
                        $result['status'] = 0;
                        $result['type_message'] = 'error';
                        $result['message'] = __('No data found');
                    } else {
                        foreach ($client['code_accounts'] as $value) {
                            $code_account[$value['id']] = $value['description_account'];
                        }
                        $result['status'] = 1;
                        $result['type_message'] = 'success';
                    }
                    $result['data'] = $client;
                    $result['accounts'] = $code_account;
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'type_document' => 'required',
                    'document' => 'required',
                ]);
                if ($validator->fails()) {
                    $result['status'] = 0;
                    $result['title'] = __('');
                    $result['message'] = __('No data found');
                    $result['type_message'] = 'error';
                    $result['redirect'] = '';
                } else {
                    $client = $this->getClientBank($request->type_document, $request->document);

                    $result['status'] = 1;
                    $result['data'] = $client;
                    $result['type_message'] = 'success';
                    $result['redirect'] = '';
                }
            }
        } else {
            $result['status'] = 0;
            $result['title'] = __('');
            $result['message'] = __('Wrong Data');
            $result['type_message'] = 'error';
            $result['redirect'] = '';
        }

        return $result;
    }

    public function generateAccount()
    {
        if (\Request::ajax()) {
            $item = Bank::where('id', Auth::user()->toArray()['bank_id'])->select('code')->get();
            if (count($item) == 0) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('No data found');
                $result['type_message'] = 'info';
            } else {
                $item = $this->getAccount($item[0]->code);

                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Account Generated');
                $result['type_message'] = 'success';
                $result['data'] = $item;
            }
            $result['redirect'] = '';

            return $result;
        }

        return Redirect::to('home');
    }

    public function storeAccount(Request $request)
    {
        $messages = [
            'account.required' => __('Account: Required'),
            'account.unique' => __('Account: Already exists'),
            'type_account.required' => __('Type Account: Required'),
        ];
        $validator = Validator::make($request->all(), [

            'account' => 'required|unique:accounts,code_account',
            'type_account' => 'required',

        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';
            $result['redirect'] = route('type_transactions');

            return $result;
        }

        try {
            $item = new Account();
            $item->code_account = $request->account;
            $item->type_account_id = $request->type_account;
            $item->client_id = $request->id;
            $item->user_id = Auth::user()->id;
            $item->date_register = date('Y-m-d H-i-s');
            $item->ip = $request->ip();
            $item->save();

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Stored');
            $result['type_message'] = 'success';
            $result['redirect'] = '';
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['title'] = __('Type Transaction');
            $result['message'] = $e->getMessage();
            $result['type_message'] = 'error';
            $result['redirect'] = '';
        }

        return $result;
    }

    /**
     * search client exist.
     */
    public function search_client(Request $request)
    {
        if (\Request::ajax()) {
            if ($request->type_document === null || $request->document === null) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Insert Type Document and Document');
                $result['type_message'] = 'error';
                $result['redirect'] = '';

                return $result;
            }
            $client = $this->getClientBank($request->type_document, $request->document);
            if ($client === null) {
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('NOT Found, Record It');
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } else {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('The Client is Already Registered');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    /**
     * decision type form for client.
     */
    public function decision(Request $request)
    {
        if (\Request::ajax()) {
            //$type_document = TypeDocument::where('id', $request->type_document)->first();
            $type_document = TypeDocument::find($request->type_document);
            if ($type_document['type_client_id'] === $this->type_client_natural) {
                $result['status'] = 1;
                $result['title'] = __('');
                $result['type_message'] = 'success';
                $result['redirect'] = route('client.form_natural_person', ['search_person' => $request->document, 'search_person_type' => $request->type_document, 'operative' => $request->operative, 'storage' => $request->storage, 'document_des' => $type_document['abbreviation'] . '-' . $request->document]);
            } elseif ($type_document['type_client_id'] === $this->type_client_juridic) {
                $search_person = '';
                $result['status'] = 1;
                $result['title'] = __('');
                $result['type_message'] = 'success';
                $result['redirect'] = route('client.form_juridic_person', ['document_des' => $type_document['abbreviation'] . '-' . $request->document, 'operative' => $request->operative, 'storage' => $request->storage, 'type_document' => $request->type_document, 'document' => $request->document]);
            } else {
                $result['status'] = 0;
                $result['message'] = __('Unidentified customer type');
                $result['type_message'] = 'error';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    /**
     * Search date person in BDS.
     */
    public function search_person($type, $document)
    {
        if (\Request::ajax()) {
            $search_person = $this->searchREP($type, $document);

            return $search_person;
        }

        return Redirect::to('home');
    }

    /**
     * Search date person.
     */
    public function search_representatives($type, $document)
    {
        if (\Request::ajax()) {
            $result['data'] = $this->search_person($type, $document);
            $result['type_message'] = 'success';
            $result['status'] = 1;
            $result['message'] = __('');
            $result['redirect'] = '';

            return $result;
        }

        return Redirect::to('home');
    }

    /**
     * form natural person.
     */
    public function form_natural_person(Request $request)
    {
        $nationality = Nationality::pluck('name_nationality', 'id');
        $gender = Gender::pluck('name_gender', 'id');
        $country = Country::pluck('name_country', 'id');
        $economic_sector = EconomicSector::pluck('name_economic_sector', 'id');
        $activity = Activity::pluck('name_activity', 'id');
        $modality = Modality::pluck('name_modality', 'id');
        $product = Product::pluck('name_product', 'id');
        $person = $this->search_person($request->search_person_type, $request->search_person);
        $storage_person = $request->storage;
        $operative_person = $request->operative;
        $type = $request->search_person_type;
        $document = $request->search_person;
        $document_des = $request->document_des;

        return view('client.client_create_natural', compact('nationality', 'gender', 'country', 'person', 'storage_person', 'operative_person', 'economic_sector', 'activity', 'modality', 'type', 'document', 'product', 'document_des'));
    }

    /**
     * form person juridic.
     */
    public function form_juridic_person(Request $request)
    {
        if (\Request::ajax()) {
            $type_document = TypeDocument::where('type_client_id', '=', $this->type_client_natural)->pluck('abbreviation', 'id');
            $operator_phone = TelephoneOperator::pluck('code', 'id');
            $country = Country::pluck('name_country', 'id');
            $state = State::pluck('name_state', 'id');
            $municipality = Municipality::pluck('name_municipality', 'id');
            $city = City::pluck('name_city', 'id');
            $postal_code = PostalCode::pluck('code', 'id');
            $economic_sector = EconomicSector::pluck('name_economic_sector', 'id');
            $activity = Activity::pluck('name_activity', 'id');
            $modality = Modality::pluck('name_modality', 'id');
            $franchise = Franchise::where('status', 1)->pluck('name_franchise', 'id');
            $product = Product::pluck('name_product', 'id');
            $gender = Gender::pluck('name_gender', 'id');
            $type = $request->type_document;
            $document = $request->document;
            $document_des = $request->document_des;
            $storage_client = $request->storage;
            $operative_client = $request->operative;

            return view('client.client_create_juridic', compact('type_document', 'operator_phone', 'country', 'municipality', 'state', 'city', 'postal_code', 'document', 'storage_client', 'operative_client', 'type', 'document_des', 'economic_sector', 'activity', 'modality', 'franchise', 'product', 'gender'));
        }

        return Redirect::to('home');
    }

    /**
     * store form person natural.
     */
    public function store_person_natural(Request $request)
    {
        $messages = [
            'person_type.required' => __('Type Documen Required'),
            'person_doc.required' => __('Document Required'),
            'storage.required' => __('Storage Required'),
            'operative.required' => __('Operative Required'),
            'first_name.required' => __('First Name Required'),
            'last_name.required' => __('Last Name Required'),
            'first_surname.required' => __('Fist Surname Required'),
            'month.required' => __('Month expliration of document Required'),
            'year.required' => __('Year expiration of document Required'),
            'nationality.required' => __('Nationality Required'),
            'gender.required' => __('Gender Required'),
            'telephone_operators_house.required' => __('Telephone house Required'),
            'phone_house.required' => __('Telephone Number of house Required'),
            'telephone_operators_cell.required' => __('Telephone cell Required'),
            'phone_cell.required' => __('Telephone Number of cell Required'),
            'email.required' => __('Email Required'),
            'country.required' => __('Country Required'),
            'state.required' => __('State Required'),
            'municipality.required' => __('Municipality Required'),
            'city.required' => __('City Required'),
            'postal_code.required' => __('Postal Code Required'),
            'edif_qta_torre.required' => __('Edif, Qt of tower Required'),
            'floor.required' => __('Floor Required'),
            'apto_offic_loc_casa.required' => __('apt, office, loc of house Required'),
            'urbanization.required' => __('Urbanization Required'),
            'reference.required' => __('Reference Required'),
            'economic_sector.required' => __('Economic Sector Required'),
            'economic_activity.required' => __('Economic Activity Required'),
            'modality.required' => __('Modality Required'),
            'product.required' => __('Product Required'),
        ];
        $validator = Validator::make($request->all(), [
            'person_type' => 'required',
            'person_doc' => 'required',
            'storage' => 'required',
            'operative' => 'required',
            'first_name' => 'required|alpha_spaces',
            'last_name' => 'required|alpha_spaces',
            'first_surname' => 'required|alpha_spaces',
            'last_surname' => 'required|alpha_spaces',
            'month' => 'required',
            'year' => 'required',
            'date_birth' => 'required',
            'nationality' => 'required|numeric',
            'gender' => 'required|numeric',
            'telephone_operators_house' => 'required|numeric',
            'phone_house' => 'required|numeric',
            'telephone_operators_cell' => 'required|numeric',
            'phone_cell' => 'required|numeric',
            'email' => 'required|email',
            'country' => 'required|numeric',
            'state' => 'required|numeric',
            'municipality' => 'required|numeric',
            'city' => 'required|numeric',
            'postal_code' => 'required|numeric',
            'edif_qta_torre' => 'required|alpha_num',
            'floor' => 'required',
            'apto_offic_loc_casa' => 'required|alpha_num',
            'urbanization' => 'required|alpha_num',
            'reference' => 'required|alpha_num',
            'economic_sector' => 'required|numeric',
            'economic_activity' => 'required|numeric',
            'modality' => 'required|numeric',
        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['title'] = __('Client');
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';

            return $result;
        }
        $conditional = true;

        try {
            $client = new Client();
            $client->type_document_id = $request->person_type;
            $client->document = $request->person_doc;
            $client->status = 1;
            $client->operative_id = $request->operative;
            $client->storage_id = $request->storage;
            $client->user_id = Auth::user()->id;
            $client->date_register = now();
            $client->ip = \Request::ip();
            $client->save();
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['title'] = __('');
            $result['message'] = __('Failed to register customer data in table client, contact the administrator.');
            $result['type_message'] = 'error';
            $result['redirect'] = '';
            $conditional = false;
        }
        if ($conditional == true) {
            try {
                $people = new Person();
                $people->first_name = $request->first_name;
                $people->second_name = $request->last_name;
                $people->first_surname = $request->first_surname;
                $people->second_surname = $request->last_surname;
                $people->date_birth = $this->saveDate($request->date_birth);
                $people->expiration_month = $request->month;
                $people->expiration_year = $request->year;
                $people->phone_house = $request->phone_house;
                $people->phone_cell = $request->phone_house;
                $people->email = $request->email;
                $people->telephone_house_operator_id = $request->telephone_operators_house;
                $people->telephone_cell_operator_id = $request->telephone_operators_cell;
                $people->gender_id = $request->gender;
                $people->nationality_id = $request->nationality;
                $people->client_id = $client->id;
                $people->save();
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table person, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                $address = new ClientAddress();
                $address->edf_qta_tow = $request->edif_qta_torre;
                $address->apto_offic_loc_house = $request->apto_offic_loc_casa;
                $address->urbanization = $request->urbanization;
                $address->reference_point = $request->reference;
                $address->country_id = $request->country;
                $address->state_id = $request->state;
                $address->municipality_id = $request->municipality;
                $address->city_id = $request->city;
                $address->postal_code_id = $request->postal_code;
                $address->nro_floor = $request->floor;
                $address->client_id = $client->id;
                $address->save();
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table client address, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                $econimic_activity = new EconomicActivity();
                $econimic_activity->economic_sector_id = $request->economic_sector;
                $econimic_activity->activity_id = $request->economic_activity;
                $econimic_activity->product_id = $request->product;
                $econimic_activity->modality_id = $request->modality;
                $econimic_activity->client_id = $client->id;
                $econimic_activity->save();
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table economic activity, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                $miselaneus = new Miscellaneous();
                $miselaneus->name_miscelaneous = $request->twitter;
                $miselaneus->social_network_id = $this->social_network_twitter;
                $miselaneus->client_id = $client->id;
                $miselaneus->user_id = Auth::user()->id;
                $miselaneus->date_register = now();
                $miselaneus->ip = \Request::ip();
                $miselaneus->save();
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table miscellaneous twitter, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                $miselaneus = new Miscellaneous();
                $miselaneus->name_miscelaneous = $request->facebook;
                $miselaneus->social_network_id = $this->social_network_facebook;
                $miselaneus->client_id = $client->id;
                $miselaneus->user_id = Auth::user()->id;
                $miselaneus->date_register = now();
                $miselaneus->ip = \Request::ip();
                $miselaneus->save();
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table miscellaneous facebook, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                $miselaneus = new Miscellaneous();
                $miselaneus->name_miscelaneous = $request->instagram;
                $miselaneus->social_network_id = $this->social_network_instagram;
                $miselaneus->client_id = $client->id;
                $miselaneus->user_id = Auth::user()->id;
                $miselaneus->date_register = now();
                $miselaneus->ip = \Request::ip();
                $miselaneus->save();
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table miscellaneous instagram, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Successful Registered Client, With registration number: ') . $this->FullSerial($client->id, 8);
            $result['type_message'] = 'success';
            $result['redirect'] = route('client');
        }

        return $result;
    }

    /**
     * store form person juridic.
     */
    public function store_person_juridic(Request $request)
    {
        $messages = [
            'type.required' => __('Type Documen Required'),
            'document.required' => __('Documen Required'),
            'storage.required' => __('Storage Required'),
            'operative.required' => __('Operative Required'),
            'razon_social.required' => __('Razon Social Required'),
            'fantasy_name.required' => __('Fantasy Name Required'),
            'telephone_operators.required' => __('Operator Required'),
            'phone.required' => __('Phone Required'),
            'email.required' => __('Email Required'),
            'country.required' => __('Country Required'),
            'state.required' => __('State Required'),
            'municipality.required' => __('Municipality Required'),
            'city.required' => __('City Required'),
            'postal_code.required' => __('Postal Code Required'),
            'edif_qta_torre.required' => __('Edif, Qt of tower Required'),
            'floor.required' => __('Floor Required'),
            'apto_offic_loc_casa.required' => __('apt, office, loc of house Required'),
            'urbanization.required' => __('Urbanization Required'),
            'reference.required' => __('Reference Required'),
            'type_document_legal.required' => __('Type Document of legal representative Required'),
            'document_legal.required' => __('Type Document of legal representative Required'),
            'first_name_legal.required' => __('first name of legal representative Required'),
            'first_surname_legal.required' => __('first surname of legal representative Required'),
            'date_birth_legal.required' => __('Date Birth legal representative Required'),
            'month_legal.required' => __('Month expiration of document legal representative Required'),
            'year_legal.required' => __('Year expiration of document legal representative Required'),
            'telephone_operator_legal.required' => __('Operator of number legal representative Required'),
            'phone_legal.required' => __('Number legal representative Required'),
            'position_legal.required' => __('The position of legal representative Required'),
            'email_legal.required' => __('The email of legal representative Required'),
            'economic_activity.required' => __('Economic Activity Required'),
            'modality.required' => __('Modality Required'),
            'product.required' => __('Product Required'),
        ];

        if ($request->repeat_data == 0) {
            $rules['type_document_commerce'] = 'required|numeric';
            $rules['document_commerce'] = 'required';
            $rules['first_name_commerce'] = 'required|alpha_spaces';
            $rules['first_surname_commerce'] = 'required|alpha_spaces';
            $rules['date_birth_commerce'] = 'required';
            $rules['month_commerce'] = 'required';
            $rules['year_commerce'] = 'required';
            $rules['telephone_operator_commerce'] = 'required|numeric';
            $rules['phone_commerce'] = 'required|numeric';
            $rules['position_commerce'] = 'required';
            $rules['email_commerce'] = 'required|email';
        }

        $validator = Validator::make($request->all(), [
            'document' => 'required',
            'type' => 'required',
            'storage' => 'required',
            'operative' => 'required',
            'razon_social' => 'required|alpha_spaces',
            'fantasy_name' => 'required|alpha_spaces',
            'telephone_operators' => 'required|numeric',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'country' => 'required|numeric',
            'state' => 'required|numeric',
            'municipality' => 'required|numeric',
            'city' => 'required|numeric',
            'postal_code' => 'required|numeric',
            'edif_qta_torre' => 'required|alpha_num',
            'floor' => 'required|alpha_num',
            'apto_offic_loc_casa' => 'required|alpha_num',
            'urbanization' => 'required|alpha_num',
            'reference' => 'required|alpha_num',
            'type_document_legal' => 'required|numeric',
            'document_legal' => 'required',
            'first_name_legal' => 'required|alpha_spaces',
            'first_surname_legal' => 'required|alpha_spaces',
            'date_birth_legal' => 'required',
            'month_legal' => 'required',
            'year_legal' => 'required',
            'telephone_operator_legal' => 'required|numeric',
            'phone_legal' => 'required|numeric',
            'position_legal' => 'required',
            'email_legal' => 'required|email',
            'economic_sector' => 'required|numeric',
            'economic_activity' => 'required|numeric',
            'product' => 'required|numeric',
        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['title'] = __('Client');
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';

            return $result;
        }
        $conditional = true;

        try {
            $client = new Client();
            $client->type_document_id = $request->type;
            $client->document = $request->document;
            $client->status = 1;
            $client->operative_id = $request->operative;
            $client->storage_id = $request->storage;
            $client->user_id = Auth::user()->id;
            $client->date_register = now();
            $client->ip = \Request::ip();
            $client->save();
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['title'] = __('');
            $result['message'] = __('Failed to register customer data in table client, contact the administrator.');
            $result['type_message'] = 'error';
            $result['redirect'] = '';
            $conditional = false;
        }
        if ($conditional == true) {
            try {
                $commerce = new Commerce();
                $commerce->business_name = $request->razon_social;
                $commerce->trade_name = $request->fantasy_name;
                $commerce->email = $request->email;
                $commerce->phone = $request->phone;
                $commerce->telephone_operator_id = $request->telephone_operators;
                $commerce->franchise_id = $request->franchises;
                $commerce->client_id = $client->id;
                $commerce->save();
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table commerce, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                if ($request->legal_id == '') {
                    $representative_legal = new Representative();
                    $representative_legal->document = $request->document_legal;
                    $representative_legal->first_name = $request->first_name_legal;
                    $representative_legal->second_name = $request->second_name_legal;
                    $representative_legal->first_surname = $request->first_surname_legal;
                    $representative_legal->second_surname = $request->second_surname_legal;
                    $representative_legal->date_birth = $this->saveDate($request->date_birth_legal);
                    $representative_legal->expiration_month = $request->month_legal;
                    $representative_legal->expiration_year = $request->year_legal;
                    $representative_legal->phone = $request->phone_legal;
                    $representative_legal->email = $request->email_legal;
                    $representative_legal->type_document_id = $request->type_document_legal;
                    $representative_legal->gender_id = $request->gender_legal;
                    $representative_legal->telephone_operator_id = $request->telephone_operator_legal;
                    $representative_legal->save();
                    $representative_legal_id = $representative_legal->id;
                } else {
                    $representative_legal_id = $request->legal_id;
                }
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer datain table representative legal, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                if ($request->repeat_data == 0) {// if not repear data
                    $position_commerce = $request->position_commerce;
                    if ($request->legal_id == '') {
                        $representative_commerce = Representative::where([['type_document_id', '=', $request->type_document_commerce], ['document', '=', $request->document_commerce]])->first();

                        if ($representative_commerce == null) {
                            $representative_commerce = new Representative();
                            $representative_commerce->document = $request->document_commerce;
                            $representative_commerce->first_name = $request->first_name_commerce;
                            $representative_commerce->second_name = $request->second_name_commerce;
                            $representative_commerce->first_surname = $request->first_surname_commerce;
                            $representative_commerce->second_surname = $request->second_surname_commerce;
                            $representative_commerce->date_birth = $this->saveDate($request->date_birth_commerce);
                            $representative_commerce->expiration_month = $request->month_commerce;
                            $representative_commerce->expiration_year = $request->year_commerce;
                            $representative_commerce->phone = $request->phone_commerce;
                            $representative_commerce->email = $request->email_commerce;
                            $representative_commerce->type_document_id = $request->type_document_commerce;
                            $representative_commerce->gender_id = $request->gender_commerce;
                            $representative_commerce->telephone_operator_id = $request->telephone_operator_commerce;
                            $representative_commerce->save();
                        }
                        $representative_commerce_id = $representative_commerce->id;
                    } else {
                        $representative_commerce_id = $request->legal_id;
                    }
                } else {
                    $representative_commerce_id = $representative_legal_id;
                    $position_commerce = $request->position_legal;
                }
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $representative_commerce->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table representative commerce, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                $client_representative_legal = new ClientRepresentative();
                $client_representative_legal->position = $request->position_legal;
                $client_representative_legal->representative_id = $representative_legal_id;
                $client_representative_legal->type_representative_id = $this->type_representative_legal;
                $client_representative_legal->client_id = $client->id;
                $client_representative_legal->save();
                $conditional = true;
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $representative_commerce->delete();
                $client_representative_legal->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table client representative legal, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional == true) {
            try {
                $client_representative_commerce = new ClientRepresentative();
                $client_representative_commerce->position = $position_commerce;
                $client_representative_commerce->representative_id = $representative_commerce_id;
                $client_representative_commerce->type_representative_id = $this->type_representative_commerce;
                $client_representative_commerce->client_id = $client->id;
                $client_representative_commerce->save();
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $representative_commerce->delete();
                $client_representative_legal->delete();
                $client_representative_commerce->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table client representative commerce, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional === true) {
            try {
                $address = new ClientAddress();
                $address->edf_qta_tow = $request->edif_qta_torre;
                $address->apto_offic_loc_house = $request->apto_offic_loc_casa;
                $address->urbanization = $request->urbanization;
                $address->reference_point = $request->reference;
                $address->country_id = $request->country;
                $address->state_id = $request->state;
                $address->municipality_id = $request->municipality;
                $address->city_id = $request->city;
                $address->postal_code_id = $request->postal_code;
                $address->nro_floor = $request->floor;
                $address->client_id = $client->id;
                $address->save();
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $representative_commerce->delete();
                $client_representative_legal->delete();
                $client_representative_commerce->delete();
                $address->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table client address, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional === true) {
            try {
                $econimic_activity = new EconomicActivity();
                $econimic_activity->economic_sector_id = $request->economic_sector;
                $econimic_activity->activity_id = $request->economic_activity;
                $econimic_activity->product_id = $request->product;
                $econimic_activity->modality_id = $request->modality;
                $econimic_activity->client_id = $client->id;
                $econimic_activity->save();
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $representative_commerce->delete();
                $client_representative_legal->delete();
                $client_representative_commerce->delete();
                $address->delete();
                $econimic_activity->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table econimic activity, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional === true) {
            try {
                $miselaneus1 = new Miscellaneous();
                $miselaneus1->name_miscelaneous = $request->twitter;
                $miselaneus1->social_network_id = $this->social_network_twitter;
                $miselaneus1->client_id = $client->id;
                $miselaneus1->user_id = Auth::user()->id;
                $miselaneus1->date_register = now();
                $miselaneus1->ip = \Request::ip();
                $miselaneus1->save();
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $representative_commerce->delete();
                $client_representative_legal->delete();
                $client_representative_commerce->delete();
                $address->delete();
                $econimic_activity->delete();
                $miselaneus1->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table miscellaneous twitter, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional === true) {
            try {
                $miselaneus2 = new Miscellaneous();
                $miselaneus2->name_miscelaneous = $request->facebook;
                $miselaneus2->social_network_id = $this->social_network_facebook;
                $miselaneus2->client_id = $client->id;
                $miselaneus2->user_id = Auth::user()->id;
                $miselaneus2->date_register = now();
                $miselaneus2->ip = \Request::ip();
                $miselaneus2->save();
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $representative_commerce->delete();
                $client_representative_legal->delete();
                $client_representative_commerce->delete();
                $address->delete();
                $econimic_activity->delete();
                $miselaneus1->delete();
                $miselaneus2->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table miscellaneous facebook, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional === true) {
            try {
                $miselaneus3 = new Miscellaneous();
                $miselaneus3->name_miscelaneous = $request->instagram;
                $miselaneus3->social_network_id = $this->social_network_instagram;
                $miselaneus3->client_id = $client->id;
                $miselaneus3->user_id = Auth::user()->id;
                $miselaneus3->date_register = now();
                $miselaneus3->ip = \Request::ip();
                $miselaneus3->save();
            } catch (Exception $e) {
                $client->delete();
                $commerce->delete();
                $representative_legal->delete();
                $representative_commerce->delete();
                $client_representative_legal->delete();
                $client_representative_commerce->delete();
                $address->delete();
                $econimic_activity->delete();
                $miselaneus1->delete();
                $miselaneus2->delete();
                $miselaneus3->delete();
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data in table miscellaneous instagram, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
                $conditional = false;
            }
        }
        if ($conditional === true) {
            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Successful Registered Client, With registration number: ') . $this->FullSerial($client->id, 8);
            $result['type_message'] = 'success';
            $result['redirect'] = route('client');
        }

        return $result;
    }

    /**
     *  Update of Clients.
     */
    public function edit(Client $client)
    {
        if (\Request::ajax()) {
            $type_document = TypeDocument::pluck('abbreviation', 'id');

            return view('client.edit_index', compact('type_document'));
        }

        return Redirect::to('home');
    }

    /**
     *  Search of Clients for code client y RIF.
     */
    public function search_client_edit(Request $request, $type_consult = 0)
    {
        if (\Request::ajax()) {
            $error = [];
            $client = null;

            if ($request->check == 1) {
                $messages = [
                    'code_client.required' => __('The Code Client is required'),
                ];
                $validator = Validator::make($request->all(), [
                    'code_client' => 'required',
                ], $messages);
                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $key => $value) {
                        $error[$key]['message'] = $value;
                    }
                } else {
                    $client = $this->getClient($request->code_client);
                }
            } else {
                if ($request->check == 2) {
                    $messages = [
                        'document.required' => __('The Document is required'),
                        'type_document.required' => __('The Type of Document is required'),
                    ];

                    $validator = Validator::make($request->all(), [
                        'type_document' => 'required',
                        'document' => 'required',
                    ], $messages);
                    if ($validator->fails()) {
                        foreach ($validator->errors()->all() as $key => $value) {
                            $error[$key]['message'] = $value;
                        }
                    } else {
                        $client = $this->getClientBank($request->type_document, $request->document);

                        if ($client != null) {
                            if (count($client) > 1) { // if you find more than one client

                                dd('llegue');
                            } else {
                                $client = $client[0];
                            }
                        }
                    }
                }
            }

            if (count($error) > 0) {
                return view('client.edit_errors', compact('error')); // return the errors
            }
            if ($client == null) {
                return view('client.edit_not_found'); // data not found
            }                               // update of client Natural

                    $client = $client->toArray();

            $nationality = Nationality::where('status', 1)->pluck('name_nationality', 'id');
            $gender = Gender::where('status', 1)->pluck('name_gender', 'id');
            $country = Country::pluck('name_country', 'id');
            $city = City::pluck('name_city', 'id');
            $municipality = Municipality::pluck('name_municipality', 'id');
            $postal_code = PostalCode::pluck('code', 'id');
            $economic_sector = EconomicSector::where('status', 1)->pluck('name_economic_sector', 'id');
            $activity = Activity::where('status', 1)->pluck('name_activity', 'id');
            $modality = Modality::where('status', 1)->pluck('name_modality', 'id');
            $product = Product::where('status', 1)->pluck('name_product', 'id');

            if ($client['get_type_document']['type_client_id'] == 1) { // if client is Natural
                if ($type_consult == 0) {
                    return view('client.edit_natural', compact('client', 'nationality', 'gender', 'country', 'economic_sector', 'activity', 'modality', 'product', 'municipality', 'city', 'postal_code'));
                }

                return view('consult_clients.show_natural', compact('client'));
            }                        // update of client Juridic

            if ($client['get_type_document']['type_client_id'] == 2) { // if client is Juridic

                $type_document = TypeDocument::where('type_client_id', '=', $this->type_client_natural)->pluck('abbreviation', 'id');

                $operator_phone = TelephoneOperator::pluck('code', 'id');
                $country = Country::pluck('name_country', 'id');
                $state = State::pluck('name_state', 'id');
                $municipality = Municipality::pluck('name_municipality', 'id');
                $city = City::pluck('name_city', 'id');
                $postal_code = PostalCode::pluck('code', 'id');
                $economic_sector = EconomicSector::where('status', 1)->pluck('name_economic_sector', 'id');
                $activity = Activity::where('status', 1)->pluck('name_activity', 'id');
                $modality = Modality::where('status', 1)->pluck('name_modality', 'id');
                $franchise = Franchise::where('status', 1)->pluck('name_franchise', 'id');
                $product = Product::where('status', 1)->pluck('name_product', 'id');
                $gender = Gender::where('status', 1)->pluck('name_gender', 'id');
                $type = $request->type;
                $document = $request->document;
                if ($type_consult == 0) {
                    return view('client.edit_juridic', compact('client', 'type_document', 'document', 'type', 'operator_phone', 'country', 'municipality', 'state', 'city', 'postal_code', 'economic_sector', 'activity', 'modality', 'franchise', 'product', 'gender'));
                }

                return view('consult_clients.show_juridic', compact('client'));
            }          //form No Available
            dd('No Available');
        } else {
            return Redirect::to('home');
        }
    }

    /**
     * form natural person Update send data.
     */
    public function update_person_natural(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'first_name.required' => __('First Name Required'),
                'first_name.alpha_spaces' => __('The First Name may only contain letters and spaces'),
                'last_name.required' => __('Last Name Required'),
                'last_name.alpha_spaces' => __('The Last Name may only contain letters and spaces'),
                'first_surname.required' => __('Fist Surname Required'),
                'first_surname.alpha_spaces' => __('The Fist Surname may only contain letters and spaces'),
                'last_surname.required' => __('Second Surname Required'),
                'last_surname.alpha_spaces' => __('The Second Surname may only contain letters and spaces'),
                'month.required' => __('Month expliration of document Required'),
                'year.required' => __('Year expiration of document Required'),
                'date_birth.required' => __('Date Birth Required'),
                'nationality.required' => __('Nationality Required'),
                'gender.required' => __('Gender Required'),
                'telephone_operators_house.required' => __('Telephone house Required'),
                'phone_house.required' => __('Telephone Number of house Required'),
                'telephone_operators_cell.required' => __('Telephone cell Required'),
                'phone_cell.required' => __('Telephone Number of cell Required'),
                'email.required' => __('Email Required'),
                'email.email' => __('Email formmat no valid'),
                'country.required' => __('Country Required'),
                'state.required' => __('State Required'),
                'municipality.required' => __('Municipality Required'),
                'city.required' => __('City Required'),
                'postal_code.required' => __('Postal Code Required'),
                'edif_qta_torre.required' => __('Edif, Qt of tower Required'),
                'nro_floor.required' => __('Nro Floor Required'),
                'apto_offic_loc_casa.required' => __('apt, office, loc of house Required'),
                'urbanization.required' => __('Urbanization Required'),
                'reference.required' => __('Reference Required'),
                'economic_sector.required' => __('Economic Sector Required'),
                'economic_activity.required' => __('Economic Activity Required'),
                'modality.required' => __('Modality Required'),
                'product.required' => __('Product Required'),
            ];

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|alpha_spaces',
                'last_name' => 'required|alpha_spaces',
                'first_surname' => 'required|alpha_spaces',
                'last_surname' => 'required|alpha_spaces',
                'month' => 'required',
                'year' => 'required',
                'date_birth' => 'required',
                'nationality' => 'required|numeric',
                'gender' => 'required|numeric',
                'telephone_operators_house' => 'required|numeric',
                'phone_house' => 'required|numeric',
                'telephone_operators_cell' => 'required|numeric',
                'phone_cell' => 'required|numeric',
                'email' => 'required|email',
                'country' => 'required|numeric',
                'state' => 'required|numeric',
                'municipality' => 'required|numeric',
                'city' => 'required|numeric',
                'postal_code' => 'required|numeric',
                'edif_qta_torre' => 'required',
                'nro_floor' => 'required',
                'apto_offic_loc_casa' => 'required',
                'urbanization' => 'required',
                'reference' => 'required',
                'economic_sector' => 'required|numeric',
                'economic_activity' => 'required|numeric',
                'modality' => 'required|numeric',
                'product' => 'required|numeric',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Edit Client Person Natural');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('client_edit');
            } else {
                $conditional = true;

                try {
                    $peopleUpdate = Person::where('client_id', $request->id)->first();
                    $peopleUpdate->first_name = $request->first_name;
                    $peopleUpdate->second_name = $request->last_name;
                    $peopleUpdate->first_surname = $request->first_surname;
                    $peopleUpdate->second_surname = $request->last_surname;
                    $peopleUpdate->date_birth = $this->saveDate($request->date_birth);
                    $peopleUpdate->expiration_month = $request->month;
                    $peopleUpdate->expiration_year = $request->year;
                    $peopleUpdate->phone_house = $request->phone_house;
                    $peopleUpdate->phone_cell = $request->phone_cell;
                    $peopleUpdate->email = $request->email;
                    $peopleUpdate->gender_id = $request->gender;
                    $peopleUpdate->telephone_house_operator_id = $request->telephone_operators_house;
                    $peopleUpdate->telephone_cell_operator_id = $request->telephone_operators_cell;
                    $peopleUpdate->nationality_id = $request->nationality;
                    $peopleUpdate->save();
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('');
                    $result['message'] = __('Failed to register customer data in table Person, contact the administrator.');
                    $result['type_message'] = 'error';
                    $result['redirect'] = '';
                    $conditional = false;
                }
                if ($conditional == true) {
                    try {
                        $addressUpdate = ClientAddress::where('client_id', $request->id)->first();
                        $addressUpdate->country_id = $request->country;
                        $addressUpdate->state_id = $request->state;
                        $addressUpdate->municipality_id = $request->municipality;
                        $addressUpdate->city_id = $request->city;
                        $addressUpdate->postal_code_id = $request->postal_code;
                        $addressUpdate->edf_qta_tow = $request->edif_qta_torre;
                        $addressUpdate->nro_floor = $request->nro_floor;
                        $addressUpdate->apto_offic_loc_house = $request->apto_offic_loc_casa;
                        $addressUpdate->urbanization = $request->urbanization;
                        $addressUpdate->reference_point = $request->reference;
                        $addressUpdate->save();
                    } catch (Exception $e) {
                        $peopleUpdate->delete();
                        $addressUpdate->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Client Address, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }

                if ($conditional == true) {
                    try {
                        $econimicActivityUpdate = EconomicActivity::where('client_id', $request->id)->first();
                        $econimicActivityUpdate->economic_sector_id = $request->economic_sector;
                        $econimicActivityUpdate->activity_id = $request->economic_activity;
                        $econimicActivityUpdate->product_id = $request->product;
                        $econimicActivityUpdate->modality_id = $request->modality;
                        $econimicActivityUpdate->save();
                    } catch (Exception $e) {
                        $peopleUpdate->delete();
                        $addressUpdate->delete();
                        $econimicActivityUpdate->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Economic Activity, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $miselaneusUpdateF = Miscellaneous::where('client_id', $request->id)->where('social_network_id', 1)->first();
                        if ($miselaneusUpdateF == null) {
                            $miselaneusUpdateF = new Miscellaneous();
                            $miselaneusUpdateF->social_network_id = $this->social_network_facebook; //1
                            $miselaneusUpdateF->client_id = $request->id;
                            $miselaneusUpdateF->user_id = Auth::user()->id;
                            $miselaneusUpdateF->date_register = now();
                            $miselaneusUpdateF->ip = \Request::ip();
                        }
                        $miselaneusUpdateF->name_miscelaneous = $request->Facebook;
                        $miselaneusUpdateF->save();
                    } catch (Exception $e) {
                        $peopleUpdate->delete();
                        $addressUpdate->delete();
                        $econimicActivityUpdate->delete();
                        $miselaneusUpdateF->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Miscellaneous Facebook, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $miselaneusUpdateI = Miscellaneous::where('client_id', $request->id)->where('social_network_id', 2)->first();
                        if ($miselaneusUpdateI == null) {
                            $miselaneusUpdateI = new Miscellaneous();
                            $miselaneusUpdateI->social_network_id = $this->social_network_instagram; //2
                            $miselaneusUpdateI->client_id = $request->id;
                            $miselaneusUpdateI->user_id = Auth::user()->id;
                            $miselaneusUpdateI->date_register = now();
                            $miselaneusUpdateI->ip = \Request::ip();
                        }
                        $miselaneusUpdateI->name_miscelaneous = $request->Instagram;
                        $miselaneusUpdateI->save();
                    } catch (Exception $e) {
                        $peopleUpdate->delete();
                        $addressUpdate->delete();
                        $econimicActivityUpdate->delete();
                        $miselaneusUpdateF->delete();
                        $miselaneusUpdateI->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Miscellaneous Instagram, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $miselaneusUpdateT = Miscellaneous::where('client_id', $request->id)->where('social_network_id', 3)->first();
                        if ($miselaneusUpdateT == null) {
                            $miselaneusUpdateT = new Miscellaneous();
                            $miselaneusUpdateT->social_network_id = $this->social_network_twitter; //3
                            $miselaneusUpdateT->client_id = $request->id;
                            $miselaneusUpdateT->user_id = Auth::user()->id;
                            $miselaneusUpdateT->date_register = now();
                            $miselaneusUpdateT->ip = \Request::ip();
                        }
                        $miselaneusUpdateT->name_miscelaneous = $request->Twitter;
                        $miselaneusUpdateT->save();
                    } catch (Exception $e) {
                        $peopleUpdate->delete();
                        $addressUpdate->delete();
                        $econimicActivityUpdate->delete();
                        $miselaneusUpdateF->delete();
                        $miselaneusUpdateI->delete();
                        $miselaneusUpdateT->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Miscellaneous Twitter, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional === true) {
                    $result['status'] = 1;
                    $result['title'] = __('Edit Client Person Natural');
                    $result['message'] = __('Updated');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('client_edit');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    /**
     * form juridic person Update send data.
     */
    public function update_person_juridic(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'business_name.required' => __('Business Name Required'),
                'trade_name.required' => __('Fantasy Name Required'),
                'telephone_operators.required' => __('Operator Required'),
                'phone.required' => __('Phone Required'),
                'email.required' => __('Email Required'),
                'country.required' => __('Country Required'),
                'state.required' => __('State Required'),
                'municipality.required' => __('Municipality Required'),
                'city.required' => __('City Required'),
                'postal_code.required' => __('Postal Code Required'),
                'edif_qta_torre.required' => __('Edif, Qt of tower Required'),
                'nro_floor.required' => __('Nro Floor Required'),
                'apto_offic_loc_casa.required' => __('apt, office, loc of house Required'),
                'urbanization.required' => __('Urbanization Required'),
                'reference.required' => __('Reference Required'),
                'type_document_legal.required' => __('Type Document of legal representative Required'),
                'document_legal.required' => __('Type Document of legal representative Required'),
                'first_name_legal.required' => __('firt name of legal representative Required'),
                'first_name_legal.alpha_spaces' => __('The firt name may only contain letters and spaces'),
                'first_surname_legal.required' => __('firt surname of legal representative Required'),
                'first_surname_legal.alpha_spaces' => __('The firt surname may only contain letters and spaces'),
                'date_birth_legal.required' => __('Date Birth legal representative Required'),
                'month_legal.required' => __('Month expiration of document legal representative Required'),
                'year_legal.required' => __('Year expiration of document legal representative Required'),
                'telephone_operator_legal.required' => __('Operator of number legal representative Required'),
                'phone_legal.required' => __('Number legal representative Required'),
                'position_legal.required' => __('The position of legal representative Required'),
                'email_legal.required' => __('The email of legal representative Required'),
                'type_document_commerce.required' => __('Type Document of commerce representative Required'),
                'first_name_commerce.required' => __('firt name of commerce representative Required'),
                'first_name_commerce.alpha_spaces' => __('The firt name commerce may only contain letters and spaces'),
                'first_surname_commerce.required' => __('firt surname of commerce representative Required'),
                'first_surname_commerce.alpha_spaces' => __('The Firt Surname commerce may only contain letters and spaces'),
                'date_birth_commerce.required' => __('Date Birth commerce representative Required'),
                'month_commerce.required' => __('Month expiration of document commerce representative Required'),
                'year_commerce.required' => __('Year expiration of document commerce representative Required'),
                'telephone_operator_commerce.required' => __('Operator of number commerce representative Required'),
                'phone_commerce.required' => __('Number commerce representative Required'),
                'position_commerce.required' => __('The position of commerce representative Required'),
                'email_commerce.required' => __('The email of commerce representative Required'),
                'economic_sector.required' => __('Economic Sector Required'),
                'economic_activity.required' => __('Economic Activity Required'),
                'modality.required' => __('Modality Required'),
                'product.required' => __('Product Required'),
            ];
            $validator = Validator::make($request->all(), [
                'business_name' => 'required',
                'trade_name' => 'required',
                'telephone_operators' => 'required|numeric',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'country' => 'required|numeric',
                'state' => 'required|numeric',
                'municipality' => 'required|numeric',
                'city' => 'required|numeric',
                'postal_code' => 'required|numeric',
                'edif_qta_torre' => 'required',
                'nro_floor' => 'required',
                'apto_offic_loc_casa' => 'required',
                'urbanization' => 'required',
                'reference' => 'required',
                'type_document_legal' => 'required|numeric',
                'document_legal' => 'required',
                'first_name_legal' => 'required|alpha_spaces',
                'first_surname_legal' => 'required|alpha_spaces',
                'date_birth_legal' => 'required',
                'month_legal' => 'required',
                'year_legal' => 'required',
                'telephone_operator_legal' => 'required|numeric',
                'phone_legal' => 'required|numeric',
                'position_legal' => 'required',
                'email_legal' => 'required|email',
                'type_document_commerce' => 'required|numeric',
                'document_commerce' => 'required',
                'first_name_commerce' => 'required|alpha_spaces',
                'first_surname_commerce' => 'required|alpha_spaces',
                'date_birth_commerce' => 'required',
                'month_commerce' => 'required',
                'year_commerce' => 'required',
                'telephone_operator_commerce' => 'required|numeric',
                'phone_commerce' => 'required|numeric',
                'position_commerce' => 'required',
                'email_commerce' => 'required|email',
                'economic_sector' => 'required|numeric',
                'economic_activity' => 'required|numeric',
                'product' => 'required|numeric',
            ], $messages);
            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Edit Client Person Juridic');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
            } else {
                $conditional = true;

                try {
                    $commerceUpdate = Commerce::where('client_id', $request->id)->first();
                    $commerceUpdate->business_name = $request->business_name;
                    $commerceUpdate->trade_name = $request->trade_name;
                    $commerceUpdate->telephone_operator_id = $request->telephone_operators;
                    $commerceUpdate->phone = $request->phone;
                    $commerceUpdate->email = $request->email;
                    $commerceUpdate->franchise_id = $request->franchises;
                    $commerceUpdate->save();
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('');
                    $result['message'] = __('Failed to register customer data in table Commerce, contact the administrator.');
                    $result['type_message'] = 'error';
                    $result['redirect'] = '';
                    $conditional = false;
                }
                if ($conditional == true) {
                    $representative_legal = Representative::where('type_document_id', $request->type_document_legal)->where('document', $request->document_legal)->first();
                    if ($representative_legal == null) {
                        try {
                            $representative_legal = new Representative();
                            $representative_legal->document = $request->document_legal;
                            $representative_legal->first_name = $request->first_name_legal;
                            $representative_legal->second_name = $request->second_name_legal;
                            $representative_legal->first_surname = $request->first_surname_legal;
                            $representative_legal->second_surname = $request->second_surname_legal;
                            $representative_legal->date_birth = $this->saveDate($request->date_birth_legal);
                            $representative_legal->expiration_month = $request->month_legal;
                            $representative_legal->expiration_year = $request->year_legal;
                            $representative_legal->phone = $request->phone_legal;
                            $representative_legal->email = $request->email_legal;
                            $representative_legal->type_document_id = $request->type_document_legal;
                            $representative_legal->gender_id = $request->gender_legal;
                            $representative_legal->telephone_operator_id = $request->telephone_operator_legal;
                            $representative_legal->save();
                        } catch (Exception $e) {
                            $representative_legal->delete();

                            $result['status'] = 0;
                            $result['title'] = __('');
                            $result['message'] = __('Failed to register customer data in table Representative Legal register, contact the administrator.');
                            $result['type_message'] = 'error';
                            $result['redirect'] = '';
                            $conditional = false;
                        }
                    } else {
                        try {
                            if ($representative_legal->document != $request->document_legal) {
                                $representative_legal->document = $request->document_legal;
                            }
                            $representative_legal->first_name = $request->first_name_legal;
                            $representative_legal->second_name = $request->second_name_legal;
                            $representative_legal->first_surname = $request->first_surname_legal;
                            $representative_legal->second_surname = $request->second_surname_legal;
                            $representative_legal->date_birth = $this->saveDate($request->date_birth_legal);
                            $representative_legal->expiration_month = $request->month_legal;
                            $representative_legal->expiration_year = $request->year_legal;
                            $representative_legal->phone = $request->phone_legal;
                            $representative_legal->email = $request->email_legal;
                            $representative_legal->type_document_id = $request->type_document_legal;
                            $representative_legal->gender_id = $request->gender_legal;
                            $representative_legal->telephone_operator_id = $request->telephone_operator_legal;
                            $representative_legal->save();
                        } catch (Exception $e) {
                            $representative_legal->delete();

                            $result['status'] = 0;
                            $result['title'] = __('');
                            $result['message'] = __('Failed to register customer data in table Representative Legal update, contact the administrator.');
                            $result['type_message'] = 'error';
                            $result['redirect'] = '';
                            $conditional = false;
                        }
                    }
                }
                if ($conditional == true) {
                    $representative_commerce = Representative::where('type_document_id', $request->type_document_commerce)->where('document', $request->document_commerce)->first();
                    //dd('llegue ps');
                    if ($representative_commerce == null) {
                        try {
                            $representative_commerce = new Representative();
                            $representative_commerce->document = $request->document_commerce;
                            $representative_commerce->first_name = $request->first_name_commerce;
                            $representative_commerce->second_name = $request->second_name_commerce;
                            $representative_commerce->first_surname = $request->first_surname_commerce;
                            $representative_commerce->second_surname = $request->second_surname_commerce;
                            $representative_commerce->date_birth = $this->saveDate($request->date_birth_commerce);
                            $representative_commerce->expiration_month = $request->month_commerce;
                            $representative_commerce->expiration_year = $request->year_commerce;
                            $representative_commerce->phone = $request->phone_commerce;
                            $representative_commerce->email = $request->email_commerce;
                            $representative_commerce->type_document_id = $request->type_document_commerce;
                            $representative_commerce->gender_id = $request->gender_commi9erce;
                            $representative_commerce->telephone_operator_id = $request->telephone_operator_commerce;
                        } catch (Exception $e) {
                            $commerceUpdate->delete();
                            $representative_legal->delete();
                            $representative_commerce->delete();

                            $result['status'] = 0;
                            $result['title'] = __('');
                            $result['message'] = __('Failed to register customer data in table Representative Commerce register, contact the administrator.');
                            $result['type_message'] = 'error';
                            $result['redirect'] = '';
                            $conditional = false;
                        }
                    } else {
                        try {
                            if ($representative_commerce->document != $request->document_commerce) {
                                $representative_commerce->document = $request->document_commerce;
                            }
                            $representative_commerce->document = $request->document_commerce;
                            $representative_commerce->first_name = $request->first_name_commerce;
                            $representative_commerce->second_name = $request->second_name_commerce;
                            $representative_commerce->first_surname = $request->first_surname_commerce;
                            $representative_commerce->second_surname = $request->second_surname_commerce;
                            $representative_commerce->date_birth = $this->saveDate($request->date_birth_commerce);
                            $representative_commerce->expiration_month = $request->month_commerce;
                            $representative_commerce->expiration_year = $request->year_commerce;
                            $representative_commerce->phone = $request->phone_commerce;
                            $representative_commerce->email = $request->email_commerce;
                            $representative_commerce->type_document_id = $request->type_document_commerce;
                            $representative_commerce->gender_id = $request->gender_commerce;
                            $representative_commerce->telephone_operator_id = $request->telephone_operator_commerce;
                            $representative_commerce->save();
                        } catch (Exception $e) {
                            $commerceUpdate->delete();
                            $representative_legal->delete();
                            $representative_commerce->delete();

                            $result['status'] = 0;
                            $result['title'] = __('');
                            $result['message'] = __('Failed to register customer data in table Representative Commerce update, contact the administrator.');
                            $result['type_message'] = 'error';
                            $result['redirect'] = '';
                            $conditional = false;
                        }
                    }
                }

                if ($conditional == true) {
                    try {
                        $client_representative_legal = ClientRepresentative::where('client_id', $request->id)->where('type_representative_id', 1)->first(); //type representative legal

                        $client_representative_legal->position = $request->position_legal;
                        $client_representative_legal->save();
                    } catch (Exception $e) {
                        $commerceUpdate->delete();
                        $representative_legal->delete();
                        $representative_commerce->delete();
                        $client_representative_legal->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Client Representative Legal, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $client_representative_commerce = ClientRepresentative::where('client_id', $request->id)->where('type_representative_id', 2)->first(); //type representative commerce

                        $client_representative_commerce->position = $request->position_commerce;
                        $client_representative_commerce->save();
                    } catch (Exception $e) {
                        $commerceUpdate->delete();
                        $representative_legal->delete();
                        $representative_commerce->delete();
                        $client_representative_legal->delete();
                        $client_representative_commerce->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Client Representative Commerce, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $addressUpdate = ClientAddress::where('client_id', $request->id)->first();
                        $addressUpdate->country_id = $request->country;
                        $addressUpdate->state_id = $request->state;
                        $addressUpdate->municipality_id = $request->municipality;
                        $addressUpdate->city_id = $request->city;
                        $addressUpdate->postal_code_id = $request->postal_code;
                        $addressUpdate->edf_qta_tow = $request->edif_qta_torre;
                        $addressUpdate->nro_floor = $request->nro_floor;
                        $addressUpdate->apto_offic_loc_house = $request->apto_offic_loc_casa;
                        $addressUpdate->urbanization = $request->urbanization;
                        $addressUpdate->reference_point = $request->reference;
                        $addressUpdate->save();
                    } catch (Exception $e) {
                        $commerceUpdate->delete();
                        $representative_legal->delete();
                        $representative_commerce->delete();
                        $client_representative_legal->delete();
                        $client_representative_commerce->delete();
                        $addressUpdate->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Client Address, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $econimicActivityUpdate = EconomicActivity::where('client_id', $request->id)->first();
                        $econimicActivityUpdate->economic_sector_id = $request->economic_sector;
                        $econimicActivityUpdate->activity_id = $request->economic_activity;
                        $econimicActivityUpdate->product_id = $request->product;
                        $econimicActivityUpdate->modality_id = $request->modality;
                        $econimicActivityUpdate->save();
                    } catch (Exception $e) {
                        $commerceUpdate->delete();
                        $representative_legal->delete();
                        $representative_commerce->delete();
                        $client_representative_legal->delete();
                        $client_representative_commerce->delete();
                        $addressUpdate->delete();
                        $econimicActivityUpdate->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Economic Activity, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $miselaneusUpdateF = Miscellaneous::where('client_id', $request->id)->where('social_network_id', 1)->first();
                        if ($miselaneusUpdateF == null) {
                            $miselaneusUpdateF = new Miscellaneous();
                            $miselaneusUpdateF->social_network_id = $this->social_network_facebook; //1
                            $miselaneusUpdateF->client_id = $request->id;
                            $miselaneusUpdateF->user_id = Auth::user()->id;
                            $miselaneusUpdateF->date_register = now();
                            $miselaneusUpdateF->ip = \Request::ip();
                        }
                        $miselaneusUpdateF->name_miscelaneous = $request->Facebook;
                        $miselaneusUpdateF->save();
                    } catch (Exception $e) {
                        $commerceUpdate->delete();
                        $representative_legal->delete();
                        $representative_commerce->delete();
                        $client_representative_legal->delete();
                        $client_representative_commerce->delete();
                        $addressUpdate->delete();
                        $econimicActivityUpdate->delete();
                        $miselaneusUpdateF->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Miscellaneous Facebook, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $miselaneusUpdateI = Miscellaneous::where('client_id', $request->id)->where('social_network_id', 2)->first();
                        if ($miselaneusUpdateI == null) {
                            $miselaneusUpdateI = new Miscellaneous();
                            $miselaneusUpdateI->social_network_id = $this->social_network_instagram; //2
                            $miselaneusUpdateI->client_id = $request->id;
                            $miselaneusUpdateI->user_id = Auth::user()->id;
                            $miselaneusUpdateI->date_register = now();
                            $miselaneusUpdateI->ip = \Request::ip();
                        }
                        $miselaneusUpdateI->name_miscelaneous = $request->Instagram;
                        $miselaneusUpdateI->save();
                    } catch (Exception $e) {
                        $commerceUpdate->delete();
                        $representative_legal->delete();
                        $representative_commerce->delete();
                        $client_representative_legal->delete();
                        $client_representative_commerce->delete();
                        $addressUpdate->delete();
                        $econimicActivityUpdate->delete();
                        $miselaneusUpdateF->delete();
                        $miselaneusUpdateI->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Miscellaneous Instagram, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    try {
                        $miselaneusUpdateT = Miscellaneous::where('client_id', $request->id)->where('social_network_id', 3)->first();
                        if ($miselaneusUpdateT == null) {
                            $miselaneusUpdateT = new Miscellaneous();
                            $miselaneusUpdateT->social_network_id = $this->social_network_twitter; //3
                            $miselaneusUpdateT->client_id = $request->id;
                            $miselaneusUpdateT->user_id = Auth::user()->id;
                            $miselaneusUpdateT->date_register = now();
                            $miselaneusUpdateT->ip = \Request::ip();
                        }
                        $miselaneusUpdateT->name_miscelaneous = $request->Twitter;
                        $miselaneusUpdateT->save();
                    } catch (Exception $e) {
                        $commerceUpdate->delete();
                        $representative_legal->delete();
                        $representative_commerce->delete();
                        $client_representative_legal->delete();
                        $client_representative_commerce->delete();
                        $addressUpdate->delete();
                        $econimicActivityUpdate->delete();
                        $miselaneusUpdateF->delete();
                        $miselaneusUpdateI->delete();
                        $miselaneusUpdateT->delete();

                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Failed to register customer data in table Miscellaneous Twitter, contact the administrator.');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                        $conditional = false;
                    }
                }
                if ($conditional == true) {
                    $result['status'] = 1;
                    $result['title'] = __('Edit Client Person Juridic');
                    $result['message'] = __('Updated');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('client_edit');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function pre_opening_account()
    {
        if (\Request::ajax()) {
            $desc_account = TypeAccount::where('status', 1)->whereIn('bank_id', Auth::user()->toArray()['list_bank_id'])->get()->toArray();
            $type_account = [];
            foreach ($desc_account as $value) {
                $type_account[$value['id']] = $value['name_product'] . ' (' . $value['bank_name'] . ') (' . $value['get_type_coin']['symbol'] . ')';
            }

            return view('client.pre_opening_account', compact('type_account'));
        }

        return Redirect::to('home');
    }

    public function pos_assignment()
    {
        if (\Request::ajax()) {
            $model = CoinTransaction::get();
            $transa = [];
            foreach ($model as $value) {
                $transa[$value->id] = $value->transa_coin;
            }

            return view('client.pos_assignment', compact('transa'));
        }

        return Redirect::to('home');
    }

    public function save_pos_client(Request $request)
    {
        if (\Request::ajax()) {
            try {
                if (is_array($request->assig)) {
                    foreach ($request->assig as $key => $value) {
                        $messages = [
                            'insurance.required' => __('Insurance is Required'),
                            'insurance.in' => __('Format Incorrect for insurance'),
                            'dual_sim.required' => __('Dual SIM is Required'),
                            'dual_sim.in' => __('Format Incorrect for dual SIM'),
                            'price.required' => __('Price is Required'),
                            'exonerate.required' => __('Exonerate is Required'),
                            'exonerate.in' => __('Format Incorrect for exonerate'),
                            'type_transation.required' => __('Type Transaction is Required'),
                            'observations.max' => __('Observations exceeds the designated maximum length'),
                        ];
                        $validator = Validator::make($value, [
                            'insurance' => 'required|in:0,1',
                            'dual_sim' => 'required|in:0,1',
                            'price' => 'required',
                            'exonerate' => 'required',
                            'type_transation' => 'required',
                            'observations' => 'max:20',
                        ], $messages);

                        if ($validator->fails()) {
                            $result['status'] = 0;
                            $result['title'] = __('POS Asignment');
                            $result['message'] = '';
                            foreach ($validator->errors()->all() as $key => $value) {
                                $result['message'] .= $value . '<br/>';
                            }
                            $result['data'] = null;
                            $result['type_message'] = 'error';
                            $result['redirect'] = '';

                            return $result;
                        }

                        $ClientPos = new ClientPos();
                        $ClientPos->price = $value['price'];
                        $ClientPos->exonerate = $value['exonerate'];
                        $ClientPos->observations = $value['observations'];
                        $ClientPos->account_id = $value['account_id'];
                        $ClientPos->pos_inventory_id = Encryptor::decrypt($value['pos_id']);
                        $ClientPos->user_id = Auth::user()->id;
                        $ClientPos->register_date = now();
                        $ClientPos->ip = $request->ip();
                        $ClientPos->save();

                        $type_trx = explode(';', substr($value['type_transation'], 0, -1));
                        foreach ($type_trx as $value2) {
                            $ClientPosTrx = new ClientPosTransaction();
                            $ClientPosTrx->coin_transactions_id = $value2;
                            $ClientPosTrx->client_pos_id = $ClientPos->id;
                            $ClientPosTrx->user_id = Auth::user()->id;
                            $ClientPosTrx->register_date = now();
                            $ClientPosTrx->ip = $request->ip();
                            $ClientPosTrx->save();
                        }
                        DB::table('pos_inventories')->where('id', Encryptor::decrypt($value['pos_id']))->update(['assigned' => true]);
                    }
                    $result['status'] = 1;
                    $result['title'] = __('POS Asignment');
                    $result['message'] = __('Stored');
                    $result['type_message'] = 'success';
                    $result['redirect'] = '';
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('POS Asignment');
                    $result['message'] = __('You must add at least one asignment');
                    $result['type_message'] = 'info';
                    $result['redirect'] = '';
                }
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('POS Asignment');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
