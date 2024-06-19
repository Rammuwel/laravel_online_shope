<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CoutrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = array(
			array('code' => 'US', 'name' => 'United States', 'mobile_code' => null),
			array('code' => 'CA', 'name' => 'Canada', 'mobile_code' => null),
			array('code' => 'AF', 'name' => 'Afghanistan', 'mobile_code' => null),
			array('code' => 'AL', 'name' => 'Albania', 'mobile_code' => null),
			array('code' => 'DZ', 'name' => 'Algeria', 'mobile_code' => null),
			array('code' => 'AS', 'name' => 'American Samoa', 'mobile_code' => null),
			array('code' => 'AD', 'name' => 'Andorra', 'mobile_code' => null),
			array('code' => 'AO', 'name' => 'Angola', 'mobile_code' => null),
			array('code' => 'AI', 'name' => 'Anguilla', 'mobile_code' => null),
			array('code' => 'AQ', 'name' => 'Antarctica', 'mobile_code' => null),
			array('code' => 'AG', 'name' => 'Antigua and/or Barbuda', 'mobile_code' => null),
			array('code' => 'AR', 'name' => 'Argentina', 'mobile_code' => null),
			array('code' => 'AM', 'name' => 'Armenia', 'mobile_code' => null),
			array('code' => 'AW', 'name' => 'Aruba', 'mobile_code' => null),
			array('code' => 'AU', 'name' => 'Australia', 'mobile_code' => null),
			array('code' => 'AT', 'name' => 'Austria', 'mobile_code' => null),
			array('code' => 'AZ', 'name' => 'Azerbaijan', 'mobile_code' => null),
			array('code' => 'BS', 'name' => 'Bahamas', 'mobile_code' => null),
			array('code' => 'BH', 'name' => 'Bahrain', 'mobile_code' => null),
			array('code' => 'BD', 'name' => 'Bangladesh', 'mobile_code' => null),
			array('code' => 'BB', 'name' => 'Barbados', 'mobile_code' => null),
			array('code' => 'BY', 'name' => 'Belarus', 'mobile_code' => null),
			array('code' => 'BE', 'name' => 'Belgium', 'mobile_code' => null),
			array('code' => 'BZ', 'name' => 'Belize', 'mobile_code' => null),
			array('code' => 'BJ', 'name' => 'Benin', 'mobile_code' => null),
			array('code' => 'BM', 'name' => 'Bermuda', 'mobile_code' => null),
			array('code' => 'BT', 'name' => 'Bhutan', 'mobile_code' => null),
			array('code' => 'BO', 'name' => 'Bolivia', 'mobile_code' => null),
			array('code' => 'BA', 'name' => 'Bosnia and Herzegovina', 'mobile_code' => null),
			array('code' => 'BW', 'name' => 'Botswana', 'mobile_code' => null),
			array('code' => 'BV', 'name' => 'Bouvet Island', 'mobile_code' => null),
			array('code' => 'BR', 'name' => 'Brazil', 'mobile_code' => null),
			array('code' => 'IO', 'name' => 'British lndian Ocean Territory', 'mobile_code' => null),
			array('code' => 'BN', 'name' => 'Brunei Darussalam', 'mobile_code' => null),
			array('code' => 'BG', 'name' => 'Bulgaria', 'mobile_code' => null),
			array('code' => 'BF', 'name' => 'Burkina Faso', 'mobile_code' => null),
			array('code' => 'BI', 'name' => 'Burundi', 'mobile_code' => null),
			array('code' => 'KH', 'name' => 'Cambodia', 'mobile_code' => null),
			array('code' => 'CM', 'name' => 'Cameroon', 'mobile_code' => null),
			array('code' => 'CV', 'name' => 'Cape Verde', 'mobile_code' => null),
			array('code' => 'KY', 'name' => 'Cayman Islands', 'mobile_code' => null),
			array('code' => 'CF', 'name' => 'Central African Republic', 'mobile_code' => null),
			array('code' => 'TD', 'name' => 'Chad', 'mobile_code' => null),
			array('code' => 'CL', 'name' => 'Chile', 'mobile_code' => null),
			array('code' => 'CN', 'name' => 'China', 'mobile_code' => null),
			array('code' => 'CX', 'name' => 'Christmas Island', 'mobile_code' => null),
			array('code' => 'CC', 'name' => 'Cocos (Keeling) Islands', 'mobile_code' => null),
			array('code' => 'CO', 'name' => 'Colombia', 'mobile_code' => null),
			array('code' => 'KM', 'name' => 'Comoros', 'mobile_code' => null),
			array('code' => 'CG', 'name' => 'Congo', 'mobile_code' => null),
			array('code' => 'CK', 'name' => 'Cook Islands', 'mobile_code' => null),
			array('code' => 'CR', 'name' => 'Costa Rica', 'mobile_code' => null),
			array('code' => 'HR', 'name' => 'Croatia (Hrvatska)', 'mobile_code' => null),
			array('code' => 'CU', 'name' => 'Cuba', 'mobile_code' => null),
			array('code' => 'CY', 'name' => 'Cyprus', 'mobile_code' => null),
			array('code' => 'CZ', 'name' => 'Czech Republic', 'mobile_code' => null),
			array('code' => 'CD', 'name' => 'Democratic Republic of Congo', 'mobile_code' => null),
			array('code' => 'DK', 'name' => 'Denmark', 'mobile_code' => null),
			array('code' => 'DJ', 'name' => 'Djibouti', 'mobile_code' => null),
			array('code' => 'DM', 'name' => 'Dominica', 'mobile_code' => null),
			array('code' => 'DO', 'name' => 'Dominican Republic', 'mobile_code' => null),
			array('code' => 'TP', 'name' => 'East Timor', 'mobile_code' => null),
			array('code' => 'EC', 'name' => 'Ecudaor', 'mobile_code' => null),
			array('code' => 'EG', 'name' => 'Egypt', 'mobile_code' => null),
			array('code' => 'SV', 'name' => 'El Salvador', 'mobile_code' => null),
			array('code' => 'GQ', 'name' => 'Equatorial Guinea', 'mobile_code' => null),
			array('code' => 'ER', 'name' => 'Eritrea', 'mobile_code' => null),
			array('code' => 'EE', 'name' => 'Estonia', 'mobile_code' => null),
			array('code' => 'ET', 'name' => 'Ethiopia', 'mobile_code' => null),
			array('code' => 'FK', 'name' => 'Falkland Islands (Malvinas)', 'mobile_code' => null),
			array('code' => 'FO', 'name' => 'Faroe Islands', 'mobile_code' => null),
			array('code' => 'FJ', 'name' => 'Fiji', 'mobile_code' => null),
			array('code' => 'FI', 'name' => 'Finland', 'mobile_code' => null),
			array('code' => 'FR', 'name' => 'France', 'mobile_code' => null),
			array('code' => 'FX', 'name' => 'France, Metropolitan', 'mobile_code' => null),
			array('code' => 'GF', 'name' => 'French Guiana', 'mobile_code' => null),
			array('code' => 'PF', 'name' => 'French Polynesia', 'mobile_code' => null),
			array('code' => 'TF', 'name' => 'French Southern Territories', 'mobile_code' => null),
			array('code' => 'GA', 'name' => 'Gabon', 'mobile_code' => null),
			array('code' => 'GM', 'name' => 'Gambia', 'mobile_code' => null),
			array('code' => 'GE', 'name' => 'Georgia', 'mobile_code' => null),
			array('code' => 'DE', 'name' => 'Germany', 'mobile_code' => null),
			array('code' => 'GH', 'name' => 'Ghana', 'mobile_code' => null),
			array('code' => 'GI', 'name' => 'Gibraltar', 'mobile_code' => null),
			array('code' => 'GR', 'name' => 'Greece', 'mobile_code' => null),
			array('code' => 'GL', 'name' => 'Greenland', 'mobile_code' => null),
			array('code' => 'GD', 'name' => 'Grenada', 'mobile_code' => null),
			array('code' => 'GP', 'name' => 'Guadeloupe', 'mobile_code' => null),
			array('code' => 'GU', 'name' => 'Guam', 'mobile_code' => null),
			array('code' => 'GT', 'name' => 'Guatemala', 'mobile_code' => null),
			array('code' => 'GN', 'name' => 'Guinea', 'mobile_code' => null),
			array('code' => 'GW', 'name' => 'Guinea-Bissau', 'mobile_code' => null),
			array('code' => 'GY', 'name' => 'Guyana', 'mobile_code' => null),
			array('code' => 'HT', 'name' => 'Haiti', 'mobile_code' => null),
			array('code' => 'HM', 'name' => 'Heard and Mc Donald Islands', 'mobile_code' => null),
			array('code' => 'HN', 'name' => 'Honduras', 'mobile_code' => null),
			array('code' => 'HK', 'name' => 'Hong Kong', 'mobile_code' => null),
			array('code' => 'HU', 'name' => 'Hungary', 'mobile_code' => null),
			array('code' => 'IS', 'name' => 'Iceland', 'mobile_code' => null),
			array('code' => 'IN', 'name' => 'India', 'mobile_code' => null),
			array('code' => 'ID', 'name' => 'Indonesia', 'mobile_code' => null),
			array('code' => 'IR', 'name' => 'Iran (Islamic Republic of)', 'mobile_code' => null),
			array('code' => 'IQ', 'name' => 'Iraq', 'mobile_code' => null),
			array('code' => 'IE', 'name' => 'Ireland', 'mobile_code' => null),
			array('code' => 'IL', 'name' => 'Israel', 'mobile_code' => null),
			array('code' => 'IT', 'name' => 'Italy', 'mobile_code' => null),
			array('code' => 'CI', 'name' => 'Ivory Coast', 'mobile_code' => null),
			array('code' => 'JM', 'name' => 'Jamaica', 'mobile_code' => null),
			array('code' => 'JP', 'name' => 'Japan', 'mobile_code' => null),
			array('code' => 'JO', 'name' => 'Jordan', 'mobile_code' => null),
			array('code' => 'KZ', 'name' => 'Kazakhstan', 'mobile_code' => null),
			array('code' => 'KE', 'name' => 'Kenya', 'mobile_code' => null),
			array('code' => 'KI', 'name' => 'Kiribati', 'mobile_code' => null),
			array('code' => 'KP', 'name' => 'Korea, Democratic People\'s Republic of', 'mobile_code' => null),
			array('code' => 'KR', 'name' => 'Korea, Republic of', 'mobile_code' => null),
			array('code' => 'KW', 'name' => 'Kuwait', 'mobile_code' => null),
			array('code' => 'KG', 'name' => 'Kyrgyzstan', 'mobile_code' => null),
			array('code' => 'LA', 'name' => 'Lao People\'s Democratic Republic', 'mobile_code' => null),
			array('code' => 'LV', 'name' => 'Latvia', 'mobile_code' => null),
			array('code' => 'LB', 'name' => 'Lebanon', 'mobile_code' => null),
			array('code' => 'LS', 'name' => 'Lesotho', 'mobile_code' => null),
			array('code' => 'LR', 'name' => 'Liberia', 'mobile_code' => null),
			array('code' => 'LY', 'name' => 'Libyan Arab Jamahiriya', 'mobile_code' => null),
			array('code' => 'LI', 'name' => 'Liechtenstein', 'mobile_code' => null),
			array('code' => 'LT', 'name' => 'Lithuania', 'mobile_code' => null),
			array('code' => 'LU', 'name' => 'Luxembourg', 'mobile_code' => null),
			array('code' => 'MO', 'name' => 'Macau', 'mobile_code' => null),
			array('code' => 'MK', 'name' => 'Macedonia', 'mobile_code' => null),
			array('code' => 'MG', 'name' => 'Madagascar', 'mobile_code' => null),
			array('code' => 'MW', 'name' => 'Malawi', 'mobile_code' => null),
			array('code' => 'MY', 'name' => 'Malaysia', 'mobile_code' => null),
			array('code' => 'MV', 'name' => 'Maldives', 'mobile_code' => null),
			array('code' => 'ML', 'name' => 'Mali', 'mobile_code' => null),
			array('code' => 'MT', 'name' => 'Malta', 'mobile_code' => null),
			array('code' => 'MH', 'name' => 'Marshall Islands', 'mobile_code' => null),
			array('code' => 'MQ', 'name' => 'Martinique', 'mobile_code' => null),
			array('code' => 'MR', 'name' => 'Mauritania', 'mobile_code' => null),
			array('code' => 'MU', 'name' => 'Mauritius', 'mobile_code' => null),
			array('code' => 'TY', 'name' => 'Mayotte', 'mobile_code' => null),
			array('code' => 'MX', 'name' => 'Mexico', 'mobile_code' => null),
			array('code' => 'FM', 'name' => 'Micronesia, Federated States of', 'mobile_code' => null),
			array('code' => 'MD', 'name' => 'Moldova, Republic of', 'mobile_code' => null),
			array('code' => 'MC', 'name' => 'Monaco', 'mobile_code' => null),
			array('code' => 'MN', 'name' => 'Mongolia', 'mobile_code' => null),
			array('code' => 'MS', 'name' => 'Montserrat', 'mobile_code' => null),
			array('code' => 'MA', 'name' => 'Morocco', 'mobile_code' => null),
			array('code' => 'MZ', 'name' => 'Mozambique', 'mobile_code' => null),
			array('code' => 'MM', 'name' => 'Myanmar', 'mobile_code' => null),
			array('code' => 'NA', 'name' => 'Namibia', 'mobile_code' => null),
			array('code' => 'NR', 'name' => 'Nauru', 'mobile_code' => null),
			array('code' => 'NP', 'name' => 'Nepal', 'mobile_code' => null),
			array('code' => 'NL', 'name' => 'Netherlands', 'mobile_code' => null),
			array('code' => 'AN', 'name' => 'Netherlands Antilles', 'mobile_code' => null),
			array('code' => 'NC', 'name' => 'New Caledonia', 'mobile_code' => null),
			array('code' => 'NZ', 'name' => 'New Zealand', 'mobile_code' => null),
			array('code' => 'NI', 'name' => 'Nicaragua', 'mobile_code' => null),
			array('code' => 'NE', 'name' => 'Niger', 'mobile_code' => null),
			array('code' => 'NG', 'name' => 'Nigeria', 'mobile_code' => null),
			array('code' => 'NU', 'name' => 'Niue', 'mobile_code' => null),
			array('code' => 'NF', 'name' => 'Norfork Island', 'mobile_code' => null),
			array('code' => 'MP', 'name' => 'Northern Mariana Islands', 'mobile_code' => null),
			array('code' => 'NO', 'name' => 'Norway', 'mobile_code' => null),
			array('code' => 'OM', 'name' => 'Oman', 'mobile_code' => null),
			array('code' => 'PK', 'name' => 'Pakistan', 'mobile_code' => null),
			array('code' => 'PW', 'name' => 'Palau', 'mobile_code' => null),
			array('code' => 'PA', 'name' => 'Panama', 'mobile_code' => null),
			array('code' => 'PG', 'name' => 'Papua New Guinea', 'mobile_code' => null),
			array('code' => 'PY', 'name' => 'Paraguay', 'mobile_code' => null),
			array('code' => 'PE', 'name' => 'Peru', 'mobile_code' => null),
			array('code' => 'PH', 'name' => 'Philippines', 'mobile_code' => null),
			array('code' => 'PN', 'name' => 'Pitcairn', 'mobile_code' => null),
			array('code' => 'PL', 'name' => 'Poland', 'mobile_code' => null),
			array('code' => 'PT', 'name' => 'Portugal', 'mobile_code' => null),
			array('code' => 'PR', 'name' => 'Puerto Rico', 'mobile_code' => null),
			array('code' => 'QA', 'name' => 'Qatar', 'mobile_code' => null),
			array('code' => 'SS', 'name' => 'Republic of South Sudan', 'mobile_code' => null),
			array('code' => 'RE', 'name' => 'Reunion', 'mobile_code' => null),
			array('code' => 'RO', 'name' => 'Romania', 'mobile_code' => null),
			array('code' => 'RU', 'name' => 'Russian Federation', 'mobile_code' => null),
			array('code' => 'RW', 'name' => 'Rwanda', 'mobile_code' => null),
			array('code' => 'KN', 'name' => 'Saint Kitts and Nevis', 'mobile_code' => null),
			array('code' => 'LC', 'name' => 'Saint Lucia', 'mobile_code' => null),
			array('code' => 'VC', 'name' => 'Saint Vincent and the Grenadines', 'mobile_code' => null),
			array('code' => 'WS', 'name' => 'Samoa', 'mobile_code' => null),
			array('code' => 'SM', 'name' => 'San Marino', 'mobile_code' => null),
			array('code' => 'ST', 'name' => 'Sao Tome and Principe', 'mobile_code' => null),
			array('code' => 'SA', 'name' => 'Saudi Arabia', 'mobile_code' => null),
			array('code' => 'SN', 'name' => 'Senegal', 'mobile_code' => null),
			array('code' => 'RS', 'name' => 'Serbia', 'mobile_code' => null),
			array('code' => 'SC', 'name' => 'Seychelles', 'mobile_code' => null),
			array('code' => 'SL', 'name' => 'Sierra Leone', 'mobile_code' => null),
			array('code' => 'SG', 'name' => 'Singapore', 'mobile_code' => null),
			array('code' => 'SK', 'name' => 'Slovakia', 'mobile_code' => null),
			array('code' => 'SI', 'name' => 'Slovenia', 'mobile_code' => null),
			array('code' => 'SB', 'name' => 'Solomon Islands', 'mobile_code' => null),
			array('code' => 'SO', 'name' => 'Somalia', 'mobile_code' => null),
			array('code' => 'ZA', 'name' => 'South Africa', 'mobile_code' => null),
			array('code' => 'GS', 'name' => 'South Georgia South Sandwich Islands', 'mobile_code' => null),
			array('code' => 'ES', 'name' => 'Spain', 'mobile_code' => null),
			array('code' => 'LK', 'name' => 'Sri Lanka', 'mobile_code' => null),
			array('code' => 'SH', 'name' => 'St. Helena', 'mobile_code' => null),
			array('code' => 'PM', 'name' => 'St. Pierre and Miquelon', 'mobile_code' => null),
			array('code' => 'SD', 'name' => 'Sudan', 'mobile_code' => null),
			array('code' => 'SR', 'name' => 'Suriname', 'mobile_code' => null),
			array('code' => 'SJ', 'name' => 'Svalbarn and Jan Mayen Islands', 'mobile_code' => null),
			array('code' => 'SZ', 'name' => 'Swaziland', 'mobile_code' => null),
			array('code' => 'SE', 'name' => 'Sweden', 'mobile_code' => null),
			array('code' => 'CH', 'name' => 'Switzerland', 'mobile_code' => null),
			array('code' => 'SY', 'name' => 'Syrian Arab Republic', 'mobile_code' => null),
			array('code' => 'TW', 'name' => 'Taiwan', 'mobile_code' => null),
			array('code' => 'TJ', 'name' => 'Tajikistan', 'mobile_code' => null),
			array('code' => 'TZ', 'name' => 'Tanzania, United Republic of', 'mobile_code' => null),
			array('code' => 'TH', 'name' => 'Thailand', 'mobile_code' => null),
			array('code' => 'TG', 'name' => 'Togo', 'mobile_code' => null),
			array('code' => 'TK', 'name' => 'Tokelau', 'mobile_code' => null),
			array('code' => 'TO', 'name' => 'Tonga', 'mobile_code' => null),
			array('code' => 'TT', 'name' => 'Trinidad and Tobago', 'mobile_code' => null),
			array('code' => 'TN', 'name' => 'Tunisia', 'mobile_code' => null),
			array('code' => 'TR', 'name' => 'Turkey', 'mobile_code' => null),
			array('code' => 'TM', 'name' => 'Turkmenistan', 'mobile_code' => null),
			array('code' => 'TC', 'name' => 'Turks and Caicos Islands', 'mobile_code' => null),
			array('code' => 'TV', 'name' => 'Tuvalu', 'mobile_code' => null),
			array('code' => 'UG', 'name' => 'Uganda', 'mobile_code' => null),
			array('code' => 'UA', 'name' => 'Ukraine', 'mobile_code' => null),
			array('code' => 'AE', 'name' => 'United Arab Emirates', 'mobile_code' => null),
			array('code' => 'GB', 'name' => 'United Kingdom', 'mobile_code' => null),
			array('code' => 'UM', 'name' => 'United States minor outlying islands', 'mobile_code' => null),
			array('code' => 'UY', 'name' => 'Uruguay', 'mobile_code' => null),
			array('code' => 'UZ', 'name' => 'Uzbekistan', 'mobile_code' => null),
			array('code' => 'VU', 'name' => 'Vanuatu', 'mobile_code' => null),
			array('code' => 'VA', 'name' => 'Vatican City State', 'mobile_code' => null),
			array('code' => 'VE', 'name' => 'Venezuela', 'mobile_code' => null),
			array('code' => 'VN', 'name' => 'Vietnam', 'mobile_code' => null),
			array('code' => 'VG', 'name' => 'Virgin Islands (British)', 'mobile_code' => null),
			array('code' => 'VI', 'name' => 'Virgin Islands (U.S.)', 'mobile_code' => null),
			array('code' => 'WF', 'name' => 'Wallis and Futuna Islands', 'mobile_code' => null),
			array('code' => 'EH', 'name' => 'Western Sahara', 'mobile_code' => null),
			array('code' => 'YE', 'name' => 'Yemen', 'mobile_code' => null),
			array('code' => 'YU', 'name' => 'Yugoslavia', 'mobile_code' => null),
			array('code' => 'ZR', 'name' => 'Zaire', 'mobile_code' => null),
			array('code' => 'ZM', 'name' => 'Zambia', 'mobile_code' => null),
			array('code' => 'ZW', 'name' => 'Zimbabwe', 'mobile_code' => null),
		);
        DB::table('countries')->insert($countries);
    }
}