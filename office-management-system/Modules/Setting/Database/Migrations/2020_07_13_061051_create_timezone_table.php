<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Model\TimeZone;

class CreateTimezoneTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_zones', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->nullable();
            $table->string('time_zone')->nullable();
            $table->timestamps();
        });
        $data = [
            ['Pacific/Midway', '(GMT-11:00) Midway Island'],
            ['US/Samoa', '(GMT-11:00) Samoa'],
            ['US/Hawaii', '(GMT-10:00) Hawaii'],
            ['US/Alaska', '(GMT-09:00) Alaska'],
            ['US/Pacific', '(GMT-08:00) Pacific Time (US &amp; Canada)'],
            ['America/Tijuana', '(GMT-08:00) Tijuana'],
            ['US/Arizona', '(GMT-07:00) Arizona'],
            ['US/Mountain', '(GMT-07:00) Mountain Time (US &amp; Canada)'],
            ['America/Chihuahua', '(GMT-07:00) Chihuahua'],
            ['America/Mazatlan', '(GMT-07:00) Mazatlan'],
            ['America/Mexico_City', '(GMT-06:00) Mexico City'],
            ['America/Monterrey', '(GMT-06:00) Monterrey'],
            ['Canada/Saskatchewan', '(GMT-06:00) Saskatchewan'],
            ['US/Central', '(GMT-06:00) Central Time (US &amp; Canada)'],
            ['US/Eastern', '(GMT-05:00) Eastern Time (US &amp; Canada)'],
            ['US/East-Indiana', '(GMT-05:00) Indiana (East)'],
            ['America/Bogota', '(GMT-05:00) Bogota'],
            ['America/Lima', '(GMT-05:00) Lima'],
            ['America/Caracas', '(GMT-04:30) Caracas'],
            ['Canada/Atlantic', '(GMT-04:00) Atlantic Time (Canada)'],
            ['America/La_Paz', '(GMT-04:00) La Paz'],
            ['America/Santiago', '(GMT-04:00) Santiago'],
            ['Canada/Newfoundland', '(GMT-03:30) Newfoundland'],
            ['America/Buenos_Aires', '(GMT-03:00) Buenos Aires'],
            ['America/Godthab', '(GMT-03:00) Greenland'],
            ['Atlantic/Stanley', '(GMT-02:00) Stanley'],
            ['Atlantic/Azores', '(GMT-01:00) Azores'],
            ['Atlantic/Cape_Verde', '(GMT-01:00) Cape Verde Is.'],
            ['Africa/Casablanca', '(GMT) Casablanca'],
            ['Europe/Dublin', '(GMT) Dublin'],
            ['Europe/Lisbon', '(GMT) Lisbon'],
            ['Europe/London', '(GMT) London'],
            ['Africa/Monrovia', '(GMT) Monrovia'],
            ['Europe/Amsterdam', '(GMT+01:00) Amsterdam'],
            ['Europe/Belgrade', '(GMT+01:00) Belgrade'],
            ['Europe/Berlin', '(GMT+01:00) Berlin'],
            ['Europe/Bratislava', '(GMT+01:00) Bratislava'],
            ['Europe/Brussels', '(GMT+01:00) Brussels'],
            ['Europe/Budapest', '(GMT+01:00) Budapest'],
            ['Europe/Copenhagen', '(GMT+01:00) Copenhagen'],
            ['Europe/Ljubljana', '(GMT+01:00) Ljubljana'],
            ['Europe/Madrid', '(GMT+01:00) Madrid'],
            ['Europe/Paris', '(GMT+01:00) Paris'],
            ['Europe/Prague', '(GMT+01:00) Prague'],
            ['Europe/Rome', '(GMT+01:00) Rome'],
            ['Europe/Sarajevo', '(GMT+01:00) Sarajevo'],
            ['Europe/Skopje', '(GMT+01:00) Skopje'],
            ['Europe/Stockholm', '(GMT+01:00) Stockholm'],
            ['Europe/Vienna', '(GMT+01:00) Vienna'],
            ['Europe/Warsaw', '(GMT+01:00) Warsaw'],
            ['Europe/Zagreb', '(GMT+01:00) Zagreb'],
            ['Europe/Athens', '(GMT+02:00) Athens'],
            ['Europe/Bucharest', '(GMT+02:00) Bucharest'],
            ['Africa/Cairo', '(GMT+02:00) Cairo'],
            ['Africa/Harare', '(GMT+02:00) Harare'],
            ['Europe/Helsinki', '(GMT+02:00) Helsinki'],
            ['Asia/Jerusalem', '(GMT+02:00) Jerusalem'],
            ['Europe/Kiev', '(GMT+02:00) Kyiv'],
            ['Europe/Minsk', '(GMT+02:00) Minsk'],
            ['Europe/Riga', '(GMT+02:00) Riga'],
            ['Europe/Sofia', '(GMT+02:00) Sofia'],
            ['Europe/Tallinn', '(GMT+02:00) Tallinn'],
            ['Europe/Vilnius', '(GMT+02:00) Vilnius'],
            ['Europe/Istanbul', '(GMT+03:00) Istanbul'],
            ['Asia/Baghdad', '(GMT+03:00) Baghdad'],
            ['Asia/Kuwait', '(GMT+03:00) Kuwait'],
            ['Africa/Nairobi', '(GMT+03:00) Nairobi'],
            ['Asia/Riyadh', '(GMT+03:00) Riyadh'],
            ['Asia/Tehran', '(GMT+03:30) Tehran'],
            ['Europe/Moscow', '(GMT+04:00) Moscow'],
            ['Asia/Baku', '(GMT+04:00) Baku'],
            ['Europe/Volgograd', '(GMT+04:00) Volgograd'],
            ['Asia/Muscat', '(GMT+04:00) Muscat'],
            ['Asia/Tbilisi', '(GMT+04:00) Tbilisi'],
            ['Asia/Yerevan', '(GMT+04:00) Yerevan'],
            ['Asia/Kabul', '(GMT+04:30) Kabul'],
            ['Asia/Karachi', '(GMT+05:00) Karachi'],
            ['Asia/Tashkent', '(GMT+05:00) Tashkent'],
            ['Asia/Kolkata', '(GMT+05:30) Kolkata'],
            ['Asia/Kathmandu', '(GMT+05:45) Kathmandu'],
            ['Asia/Yekaterinburg', '(GMT+06:00) Ekaterinburg'],
            ['Asia/Almaty', '(GMT+06:00) Almaty'],
            ['Asia/Dhaka', '(GMT+06:00) Dhaka'],
            ['Asia/Novosibirsk', '(GMT+07:00) Novosibirsk'],
            ['Asia/Bangkok', '(GMT+07:00) Bangkok'],
            ['Asia/Ho_Chi_Minh', '(GMT+07.00) Ho Chi Minh'],
            ['Asia/Jakarta', '(GMT+07:00) Jakarta'],
            ['Asia/Krasnoyarsk', '(GMT+08:00) Krasnoyarsk'],
            ['Asia/Chongqing', '(GMT+08:00) Chongqing'],
            ['Asia/Hong_Kong', '(GMT+08:00) Hong Kong'],
            ['Asia/Kuala_Lumpur', '(GMT+08:00) Kuala Lumpur'],
            ['Australia/Perth', '(GMT+08:00) Perth'],
            ['Asia/Singapore', '(GMT+08:00) Singapore'],
            ['Asia/Taipei', '(GMT+08:00) Taipei'],
            ['Asia/Ulaanbaatar', '(GMT+08:00) Ulaan Bataar'],
            ['Asia/Urumqi', '(GMT+08:00) Urumqi'],
            ['Asia/Irkutsk', '(GMT+09:00) Irkutsk'],
            ['Asia/Seoul', '(GMT+09:00) Seoul'],
            ['Asia/Tokyo', '(GMT+09:00) Tokyo'],
            ['Australia/Adelaide', '(GMT+09:30) Adelaide'],
            ['Australia/Darwin', '(GMT+09:30) Darwin'],
            ['Asia/Yakutsk', '(GMT+10:00) Yakutsk'],
            ['Australia/Brisbane', '(GMT+10:00) Brisbane'],
            ['Australia/Canberra', '(GMT+10:00) Canberra'],
            ['Pacific/Guam', '(GMT+10:00) Guam'],
            ['Australia/Hobart', '(GMT+10:00) Hobart'],
            ['Australia/Melbourne', '(GMT+10:00) Melbourne'],
            ['Pacific/Port_Moresby', '(GMT+10:00) Port Moresby'],
            ['Australia/Sydney', '(GMT+10:00) Sydney'],
            ['Asia/Vladivostok', '(GMT+11:00) Vladivostok'],
            ['Asia/Magadan', '(GMT+12:00) Magadan'],
            ['Pacific/Auckland', '(GMT+12:00) Auckland'],
            ['Pacific/Fiji', '(GMT+12:00) Fiji'],
        ];
        // $data = [
        //     ['AD', 'Europe/Andorra'],
        //     ['AE', 'Asia/Dubai'],
        //     ['AF', 'Asia/Kabul'],
        //     ['AG', 'America/Antigua'],
        //     ['AI', 'America/Anguilla'],
        //     ['AL', 'Europe/Tirane'],
        //     ['AM', 'Asia/Yerevan'],
        //     ['AO', 'Africa/Luanda'],
        //     ['AQ', 'Antarctica/McMurdo'],
        //     ['AQ', 'Antarctica/Casey'],
        //     ['AQ', 'Antarctica/Davis'],
        //     ['AQ', 'Antarctica/DumontDUrville'],
        //     ['AQ', 'Antarctica/Mawson'],
        //     ['AQ', 'Antarctica/Palmer'],
        //     ['AQ', 'Antarctica/Rothera'],
        //     ['AQ', 'Antarctica/Syowa'],
        //     ['AQ', 'Antarctica/Troll'],
        //     ['AQ', 'Antarctica/Vostok'],
        //     ['AR', 'America/Argentina/Buenos_Aires'],
        //     ['AR', 'America/Argentina/Cordoba'],
        //     ['AR', 'America/Argentina/Salta'],
        //     ['AR', 'America/Argentina/Jujuy'],
        //     ['AR', 'America/Argentina/Tucuman'],
        //     ['AR', 'America/Argentina/Catamarca'],
        //     ['AR', 'America/Argentina/La_Rioja'],
        //     ['AR', 'America/Argentina/San_Juan'],
        //     ['AR', 'America/Argentina/Mendoza'],
        //     ['AR', 'America/Argentina/San_Luis'],
        //     ['AR', 'America/Argentina/Rio_Gallegos'],
        //     ['AR', 'America/Argentina/Ushuaia'],
        //     ['AS', 'Pacific/Pago_Pago'],
        //     ['AT', 'Europe/Vienna'],
        //     ['AU', 'Australia/Lord_Howe'],
        //     ['AU', 'Antarctica/Macquarie'],
        //     ['AU', 'Australia/Hobart'],
        //     ['AU', 'Australia/Currie'],
        //     ['AU', 'Australia/Melbourne'],
        //     ['AU', 'Australia/Sydney'],
        //     ['AU', 'Australia/Broken_Hill'],
        //     ['AU', 'Australia/Brisbane'],
        //     ['AU', 'Australia/Lindeman'],
        //     ['AU', 'Australia/Adelaide'],
        //     ['AU', 'Australia/Darwin'],
        //     ['AU', 'Australia/Perth'],
        //     ['AU', 'Australia/Eucla'],
        //     ['AW', 'America/Aruba'],
        //     ['AX', 'Europe/Mariehamn'],
        //     ['AZ', 'Asia/Baku'],
        //     ['BA', 'Europe/Sarajevo'],
        //     ['BB', 'America/Barbados'],
        //     ['BD', 'Asia/Dhaka'],
        //     ['BE', 'Europe/Brussels'],
        //     ['BF', 'Africa/Ouagadougou'],
        //     ['BG', 'Europe/Sofia'],
        //     ['BH', 'Asia/Bahrain'],
        //     ['BI', 'Africa/Bujumbura'],
        //     ['BJ', 'Africa/Porto-Novo'],
        //     ['BL', 'America/St_Barthelemy'],
        //     ['BM', 'Atlantic/Bermuda'],
        //     ['BN', 'Asia/Brunei'],
        //     ['BO', 'America/La_Paz'],
        //     ['BQ', 'America/Kralendijk'],
        //     ['BR', 'America/Noronha'],
        //     ['BR', 'America/Belem'],
        //     ['BR', 'America/Fortaleza'],
        //     ['BR', 'America/Recife'],
        //     ['BR', 'America/Araguaina'],
        //     ['BR', 'America/Maceio'],
        //     ['BR', 'America/Bahia'],
        //     ['BR', 'America/Sao_Paulo'],
        //     ['BR', 'America/Campo_Grande'],
        //     ['BR', 'America/Cuiaba'],
        //     ['BR', 'America/Santarem'],
        //     ['BR', 'America/Porto_Velho'],
        //     ['BR', 'America/Boa_Vista'],
        //     ['BR', 'America/Manaus'],
        //     ['BR', 'America/Eirunepe'],
        //     ['BR', 'America/Rio_Branco'],
        //     ['BS', 'America/Nassau'],
        //     ['BT', 'Asia/Thimphu'],
        //     ['BW', 'Africa/Gaborone'],
        //     ['BY', 'Europe/Minsk'],
        //     ['BZ', 'America/Belize'],
        //     ['CA', 'America/St_Johns'],
        //     ['CA', 'America/Halifax'],
        //     ['CA', 'America/Glace_Bay'],
        //     ['CA', 'America/Moncton'],
        //     ['CA', 'America/Goose_Bay'],
        //     ['CA', 'America/Blanc-Sablon'],
        //     ['CA', 'America/Toronto'],
        //     ['CA', 'America/Nipigon'],
        //     ['CA', 'America/Thunder_Bay'],
        //     ['CA', 'America/Iqaluit'],
        //     ['CA', 'America/Pangnirtung'],
        //     ['CA', 'America/Atikokan'],
        //     ['CA', 'America/Winnipeg'],
        //     ['CA', 'America/Rainy_River'],
        //     ['CA', 'America/Resolute'],
        //     ['CA', 'America/Rankin_Inlet'],
        //     ['CA', 'America/Regina'],
        //     ['CA', 'America/Swift_Current'],
        //     ['CA', 'America/Edmonton'],
        //     ['CA', 'America/Cambridge_Bay'],
        //     ['CA', 'America/Yellowknife'],
        //     ['CA', 'America/Inuvik'],
        //     ['CA', 'America/Creston'],
        //     ['CA', 'America/Dawson_Creek'],
        //     ['CA', 'America/Fort_Nelson'],
        //     ['CA', 'America/Vancouver'],
        //     ['CA', 'America/Whitehorse'],
        //     ['CA', 'America/Dawson'],
        //     ['CC', 'Indian/Cocos'],
        //     ['CD', 'Africa/Kinshasa'],
        //     ['CD', 'Africa/Lubumbashi'],
        //     ['CF', 'Africa/Bangui'],
        //     ['CG', 'Africa/Brazzaville'],
        //     ['CH', 'Europe/Zurich'],
        //     ['CI', 'Africa/Abidjan'],
        //     ['CK', 'Pacific/Rarotonga'],
        //     ['CL', 'America/Santiago'],
        //     ['CL', 'America/Punta_Arenas'],
        //     ['CL', 'Pacific/Easter'],
        //     ['CM', 'Africa/Douala'],
        //     ['CN', 'Asia/Shanghai'],
        //     ['CN', 'Asia/Urumqi'],
        //     ['CO', 'America/Bogota'],
        //     ['CR', 'America/Costa_Rica'],
        //     ['CU', 'America/Havana'],
        //     ['CV', 'Atlantic/Cape_Verde'],
        //     ['CW', 'America/Curacao'],
        //     ['CX', 'Indian/Christmas'],
        //     ['CY', 'Asia/Nicosia'],
        //     ['CY', 'Asia/Famagusta'],
        //     ['CZ', 'Europe/Prague'],
        //     ['DE', 'Europe/Berlin'],
        //     ['DE', 'Europe/Busingen'],
        //     ['DJ', 'Africa/Djibouti'],
        //     ['DK', 'Europe/Copenhagen'],
        //     ['DM', 'America/Dominica'],
        //     ['DO', 'America/Santo_Domingo'],
        //     ['DZ', 'Africa/Algiers'],
        //     ['EC', 'America/Guayaquil'],
        //     ['EC', 'Pacific/Galapagos'],
        //     ['EE', 'Europe/Tallinn'],
        //     ['EG', 'Africa/Cairo'],
        //     ['EH', 'Africa/El_Aaiun'],
        //     ['ER', 'Africa/Asmara'],
        //     ['ES', 'Europe/Madrid'],
        //     ['ES', 'Africa/Ceuta'],
        //     ['ES', 'Atlantic/Canary'],
        //     ['ET', 'Africa/Addis_Ababa'],
        //     ['FI', 'Europe/Helsinki'],
        //     ['FJ', 'Pacific/Fiji'],
        //     ['FK', 'Atlantic/Stanley'],
        //     ['FM', 'Pacific/Chuuk'],
        //     ['FM', 'Pacific/Pohnpei'],
        //     ['FM', 'Pacific/Kosrae'],
        //     ['FO', 'Atlantic/Faroe'],
        //     ['FR', 'Europe/Paris'],
        //     ['GA', 'Africa/Libreville'],
        //     ['GB', 'Europe/London'],
        //     ['GD', 'America/Grenada'],
        //     ['GE', 'Asia/Tbilisi'],
        //     ['GF', 'America/Cayenne'],
        //     ['GG', 'Europe/Guernsey'],
        //     ['GH', 'Africa/Accra'],
        //     ['GI', 'Europe/Gibraltar'],
        //     ['GL', 'America/Godthab'],
        //     ['GL', 'America/Danmarkshavn'],
        //     ['GL', 'America/Scoresbysund'],
        //     ['GL', 'America/Thule'],
        //     ['GM', 'Africa/Banjul'],
        //     ['GN', 'Africa/Conakry'],
        //     ['GP', 'America/Guadeloupe'],
        //     ['GQ', 'Africa/Malabo'],
        //     ['GR', 'Europe/Athens'],
        //     ['GS', 'Atlantic/South_Georgia'],
        //     ['GT', 'America/Guatemala'],
        //     ['GU', 'Pacific/Guam'],
        //     ['GW', 'Africa/Bissau'],
        //     ['GY', 'America/Guyana'],
        //     ['HK', 'Asia/Hong_Kong'],
        //     ['HN', 'America/Tegucigalpa'],
        //     ['HR', 'Europe/Zagreb'],
        //     ['HT', 'America/Port-au-Prince'],
        //     ['HU', 'Europe/Budapest'],
        //     ['ID', 'Asia/Jakarta'],
        //     ['ID', 'Asia/Pontianak'],
        //     ['ID', 'Asia/Makassar'],
        //     ['ID', 'Asia/Jayapura'],
        //     ['IE', 'Europe/Dublin'],
        //     ['IL', 'Asia/Jerusalem'],
        //     ['IM', 'Europe/Isle_of_Man'],
        //     ['IN', 'Asia/Kolkata'],
        //     ['IO', 'Indian/Chagos'],
        //     ['IQ', 'Asia/Baghdad'],
        //     ['IR', 'Asia/Tehran'],
        //     ['IS', 'Atlantic/Reykjavik'],
        //     ['IT', 'Europe/Rome'],
        //     ['JE', 'Europe/Jersey'],
        //     ['JM', 'America/Jamaica'],
        //     ['JO', 'Asia/Amman'],
        //     ['JP', 'Asia/Tokyo'],
        //     ['KE', 'Africa/Nairobi'],
        //     ['KG', 'Asia/Bishkek'],
        //     ['KH', 'Asia/Phnom_Penh'],
        //     ['KI', 'Pacific/Tarawa'],
        //     ['KI', 'Pacific/Enderbury'],
        //     ['KI', 'Pacific/Kiritimati'],
        //     ['KM', 'Indian/Comoro'],
        //     ['KN', 'America/St_Kitts'],
        //     ['KP', 'Asia/Pyongyang'],
        //     ['KR', 'Asia/Seoul'],
        //     ['KW', 'Asia/Kuwait'],
        //     ['KY', 'America/Cayman'],
        //     ['KZ', 'Asia/Almaty'],
        //     ['KZ', 'Asia/Qyzylorda'],
        //     ['KZ', 'Asia/Aqtobe'],
        //     ['KZ', 'Asia/Aqtau'],
        //     ['KZ', 'Asia/Atyrau'],
        //     ['KZ', 'Asia/Oral'],
        //     ['LA', 'Asia/Vientiane'],
        //     ['LB', 'Asia/Beirut'],
        //     ['LC', 'America/St_Lucia'],
        //     ['LI', 'Europe/Vaduz'],
        //     ['LK', 'Asia/Colombo'],
        //     ['LR', 'Africa/Monrovia'],
        //     ['LS', 'Africa/Maseru'],
        //     ['LT', 'Europe/Vilnius'],
        //     ['LU', 'Europe/Luxembourg'],
        //     ['LV', 'Europe/Riga'],
        //     ['LY', 'Africa/Tripoli'],
        //     ['MA', 'Africa/Casablanca'],
        //     ['MC', 'Europe/Monaco'],
        //     ['MD', 'Europe/Chisinau'],
        //     ['ME', 'Europe/Podgorica'],
        //     ['MF', 'America/Marigot'],
        //     ['MG', 'Indian/Antananarivo'],
        //     ['MH', 'Pacific/Majuro'],
        //     ['MH', 'Pacific/Kwajalein'],
        //     ['MK', 'Europe/Skopje'],
        //     ['ML', 'Africa/Bamako'],
        //     ['MM', 'Asia/Yangon'],
        //     ['MN', 'Asia/Ulaanbaatar'],
        //     ['MN', 'Asia/Hovd'],
        //     ['MN', 'Asia/Choibalsan'],
        //     ['MO', 'Asia/Macau'],
        //     ['MP', 'Pacific/Saipan'],
        //     ['MQ', 'America/Martinique'],
        //     ['MR', 'Africa/Nouakchott'],
        //     ['MS', 'America/Montserrat'],
        //     ['MT', 'Europe/Malta'],
        //     ['MU', 'Indian/Mauritius'],
        //     ['MV', 'Indian/Maldives'],
        //     ['MW', 'Africa/Blantyre'],
        //     ['MX', 'America/Mexico_City'],
        //     ['MX', 'America/Cancun'],
        //     ['MX', 'America/Merida'],
        //     ['MX', 'America/Monterrey'],
        //     ['MX', 'America/Matamoros'],
        //     ['MX', 'America/Mazatlan'],
        //     ['MX', 'America/Chihuahua'],
        //     ['MX', 'America/Ojinaga'],
        //     ['MX', 'America/Hermosillo'],
        //     ['MX', 'America/Tijuana'],
        //     ['MX', 'America/Bahia_Banderas'],
        //     ['MY', 'Asia/Kuala_Lumpur'],
        //     ['MY', 'Asia/Kuching'],
        //     ['MZ', 'Africa/Maputo'],
        //     ['NA', 'Africa/Windhoek'],
        //     ['NC', 'Pacific/Noumea'],
        //     ['NE', 'Africa/Niamey'],
        //     ['NF', 'Pacific/Norfolk'],
        //     ['NG', 'Africa/Lagos'],
        //     ['NI', 'America/Managua'],
        //     ['NL', 'Europe/Amsterdam'],
        //     ['NO', 'Europe/Oslo'],
        //     ['NP', 'Asia/Kathmandu'],
        //     ['NR', 'Pacific/Nauru'],
        //     ['NU', 'Pacific/Niue'],
        //     ['NZ', 'Pacific/Auckland'],
        //     ['NZ', 'Pacific/Chatham'],
        //     ['OM', 'Asia/Muscat'],
        //     ['PA', 'America/Panama'],
        //     ['PE', 'America/Lima'],
        //     ['PF', 'Pacific/Tahiti'],
        //     ['PF', 'Pacific/Marquesas'],
        //     ['PF', 'Pacific/Gambier'],
        //     ['PG', 'Pacific/Port_Moresby'],
        //     ['PG', 'Pacific/Bougainville'],
        //     ['PH', 'Asia/Manila'],
        //     ['PK', 'Asia/Karachi'],
        //     ['PL', 'Europe/Warsaw'],
        //     ['PM', 'America/Miquelon'],
        //     ['PN', 'Pacific/Pitcairn'],
        //     ['PR', 'America/Puerto_Rico'],
        //     ['PS', 'Asia/Gaza'],
        //     ['PS', 'Asia/Hebron'],
        //     ['PT', 'Europe/Lisbon'],
        //     ['PT', 'Atlantic/Madeira'],
        //     ['PT', 'Atlantic/Azores'],
        //     ['PW', 'Pacific/Palau'],
        //     ['PY', 'America/Asuncion'],
        //     ['QA', 'Asia/Qatar'],
        //     ['RE', 'Indian/Reunion'],
        //     ['RO', 'Europe/Bucharest'],
        //     ['RS', 'Europe/Belgrade'],
        //     ['RU', 'Europe/Kaliningrad'],
        //     ['RU', 'Europe/Moscow'],
        //     ['RU', 'Europe/Simferopol'],
        //     ['RU', 'Europe/Volgograd'],
        //     ['RU', 'Europe/Kirov'],
        //     ['RU', 'Europe/Astrakhan'],
        //     ['RU', 'Europe/Saratov'],
        //     ['RU', 'Europe/Ulyanovsk'],
        //     ['RU', 'Europe/Samara'],
        //     ['RU', 'Asia/Yekaterinburg'],
        //     ['RU', 'Asia/Omsk'],
        //     ['RU', 'Asia/Novosibirsk'],
        //     ['RU', 'Asia/Barnaul'],
        //     ['RU', 'Asia/Tomsk'],
        //     ['RU', 'Asia/Novokuznetsk'],
        //     ['RU', 'Asia/Krasnoyarsk'],
        //     ['RU', 'Asia/Irkutsk'],
        //     ['RU', 'Asia/Chita'],
        //     ['RU', 'Asia/Yakutsk'],
        //     ['RU', 'Asia/Khandyga'],
        //     ['RU', 'Asia/Vladivostok'],
        //     ['RU', 'Asia/Ust-Nera'],
        //     ['RU', 'Asia/Magadan'],
        //     ['RU', 'Asia/Sakhalin'],
        //     ['RU', 'Asia/Srednekolymsk'],
        //     ['RU', 'Asia/Kamchatka'],
        //     ['RU', 'Asia/Anadyr'],
        //     ['RW', 'Africa/Kigali'],
        //     ['SA', 'Asia/Riyadh'],
        //     ['SB', 'Pacific/Guadalcanal'],
        //     ['SC', 'Indian/Mahe'],
        //     ['SD', 'Africa/Khartoum'],
        //     ['SE', 'Europe/Stockholm'],
        //     ['SG', 'Asia/Singapore'],
        //     ['SH', 'Atlantic/St_Helena'],
        //     ['SI', 'Europe/Ljubljana'],
        //     ['SJ', 'Arctic/Longyearbyen'],
        //     ['SK', 'Europe/Bratislava'],
        //     ['SL', 'Africa/Freetown'],
        //     ['SM', 'Europe/San_Marino'],
        //     ['SN', 'Africa/Dakar'],
        //     ['SO', 'Africa/Mogadishu'],
        //     ['SR', 'America/Paramaribo'],
        //     ['SS', 'Africa/Juba'],
        //     ['ST', 'Africa/Sao_Tome'],
        //     ['SV', 'America/El_Salvador'],
        //     ['SX', 'America/Lower_Princes'],
        //     ['SY', 'Asia/Damascus'],
        //     ['SZ', 'Africa/Mbabane'],
        //     ['TC', 'America/Grand_Turk'],
        //     ['TD', 'Africa/Ndjamena'],
        //     ['TF', 'Indian/Kerguelen'],
        //     ['TG', 'Africa/Lome'],
        //     ['TH', 'Asia/Bangkok'],
        //     ['TJ', 'Asia/Dushanbe'],
        //     ['TK', 'Pacific/Fakaofo'],
        //     ['TL', 'Asia/Dili'],
        //     ['TM', 'Asia/Ashgabat'],
        //     ['TN', 'Africa/Tunis'],
        //     ['TO', 'Pacific/Tongatapu'],
        //     ['TR', 'Europe/Istanbul'],
        //     ['TT', 'America/Port_of_Spain'],
        //     ['TV', 'Pacific/Funafuti'],
        //     ['TW', 'Asia/Taipei'],
        //     ['TZ', 'Africa/Dar_es_Salaam'],
        //     ['UA', 'Europe/Kiev'],
        //     ['UA', 'Europe/Uzhgorod'],
        //     ['UA', 'Europe/Zaporozhye'],
        //     ['UG', 'Africa/Kampala'],
        //     ['UM', 'Pacific/Midway'],
        //     ['UM', 'Pacific/Wake'],
        //     ['US', 'America/New_York'],
        //     ['US', 'America/Detroit'],
        //     ['US', 'America/Kentucky/Louisville'],
        //     ['US', 'America/Kentucky/Monticello'],
        //     ['US', 'America/Indiana/Indianapolis'],
        //     ['US', 'America/Indiana/Vincennes'],
        //     ['US', 'America/Indiana/Winamac'],
        //     ['US', 'America/Indiana/Marengo'],
        //     ['US', 'America/Indiana/Petersburg'],
        //     ['US', 'America/Indiana/Vevay'],
        //     ['US', 'America/Chicago'],
        //     ['US', 'America/Indiana/Tell_City'],
        //     ['US', 'America/Indiana/Knox'],
        //     ['US', 'America/Menominee'],
        //     ['US', 'America/North_Dakota/Center'],
        //     ['US', 'America/North_Dakota/New_Salem'],
        //     ['US', 'America/North_Dakota/Beulah'],
        //     ['US', 'America/Denver'],
        //     ['US', 'America/Boise'],
        //     ['US', 'America/Phoenix'],
        //     ['US', 'America/Los_Angeles'],
        //     ['US', 'America/Anchorage'],
        //     ['US', 'America/Juneau'],
        //     ['US', 'America/Sitka'],
        //     ['US', 'America/Metlakatla'],
        //     ['US', 'America/Yakutat'],
        //     ['US', 'America/Nome'],
        //     ['US', 'America/Adak'],
        //     ['US', 'Pacific/Honolulu'],
        //     ['UY', 'America/Montevideo'],
        //     ['UZ', 'Asia/Samarkand'],
        //     ['UZ', 'Asia/Tashkent'],
        //     ['VA', 'Europe/Vatican'],
        //     ['VC', 'America/St_Vincent'],
        //     ['VE', 'America/Caracas'],
        //     ['VG', 'America/Tortola'],
        //     ['VI', 'America/St_Thomas'],
        //     ['VN', 'Asia/Ho_Chi_Minh'],
        //     ['VU', 'Pacific/Efate'],
        //     ['WF', 'Pacific/Wallis'],
        //     ['WS', 'Pacific/Apia'],
        //     ['YE', 'Asia/Aden'],
        //     ['YT', 'Indian/Mayotte'],
        //     ['ZA', 'Africa/Johannesburg'],
        //     ['ZM', 'Africa/Lusaka'],
        //     ['ZW', 'Africa/Harare']
        // ];
        foreach ($data as $row) {
            $s = new TimeZone();
            $s->code = $row[0];
            $s->time_zone = $row[1];
            $s->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_zones');
    }
}
