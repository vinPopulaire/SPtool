<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Gender;
use App\Age;
use App\Country;
use App\Occupation;
use App\Education;
use App\MecanexUser;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\ProfileTerms;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Model::unguard();

		// $this->call('UserTableSeeder');

		$this->call('MecanexUsersTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('GenderTableSeeder');
		$this->call('AgeTableSeeder');
		$this->call('ProfileTermSeeder');
		$this->call('OccupationTableSeeder');
		$this->call('CountriesTableSeeder');
		$this->call('EducationTableSeeder');
		$this->command->info('Tables seeded!');
	}

}


class GenderTableSeeder extends Seeder {

	public function run()
	{
		DB::table('gender')->delete();

		Gender::create(['gender' => 'Male']);
		Gender::create(['gender' => 'Female']);
	}

}

class UserTableSeeder extends Seeder {
public function run()
{
	DB::table('users')->delete();

	User::create(array(

		'email' => 'mecanex@mail.com',
		'username' => 'mecanex',
		'password' => Hash::make("123456"),

	));
}

}


class MecanexUsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('mecanex_users')->delete();

		MecanexUser::create(array(
			'username' => 'skafetzo',
			'name' => 'Stella',
			'surname' => 'Kafetzoglou',
			'gender_id'=>'2',
			'age_id'=>'5',
			'education_id'=>'5',
			'occupation_id'=>'5',
			'country_id'=>'87'
		));
		MecanexUser::create(array(
			'username' => 'vassilis',
			'name' => 'Vassilis',
			'surname' => 'Merekoulias',
			'gender_id'=>'1',
			'age_id'=>'4',
			'education_id'=>'4',
			'occupation_id'=>'5',
			'country_id'=>'75'
		));
		MecanexUser::create(array(
			'username' => 'testing',
			'name' => 'Joe',
			'surname' => 'Doe',
			'gender_id'=>'2',
			'age_id'=>'3',
			'education_id'=>'2',
			'occupation_id'=>'2',
			'country_id'=>'6'
		));
	}

}


class AgeTableSeeder extends Seeder {

	public function run()
	{
		DB::table('ages')->delete();

		Age::create(['age' => 'Under 12']);
		Age::create(['age' => '12-17']);
		Age::create(['age' => '18-24']);
		Age::create(['age' => '25-34']);
		Age::create(['age' => '35-44']);
		Age::create(['age' => '45-54']);
		Age::create(['age' => '55-64']);
		Age::create(['age' => '65-74']);
		Age::create(['age' => '75 older']);
	}

}


class ProfileTermSeeder extends Seeder {

	public function run()
	{
		DB::table('profile_terms')->delete();

		ProfileTerms::create(['term' => 'car']);
		ProfileTerms::create(['term' => 'sports']);
		ProfileTerms::create(['term' => 'house']);
		ProfileTerms::create(['term' => 'Italy']);
		ProfileTerms::create(['term' => 'cinema']);
		ProfileTerms::create(['term' => 'music']);
		ProfileTerms::create(['term' => 'Rome']);
		ProfileTerms::create(['term' => 'cards']);
		ProfileTerms::create(['term' => 'disasters']);
	}

}

class EducationTableSeeder extends Seeder {

	public function run()
	{
		DB::table('education')->delete();

		Education::create(['education' => 'Basic']);
		Education::create(['education' => 'High School Diploma']);
		Education::create(['education' => 'Bachelor Degree']);
		Education::create(['education' => 'Master Degree']);
		Education::create(['education' => 'Doctoral Degree']);

	}

}

class OccupationTableSeeder extends Seeder {

	public function run()
	{
		DB::table('occupations')->delete();

		Occupation::create(['occupation' => 'Business & Finance']);
		Occupation::create(['occupation' => 'Computers & Technology']);
		Occupation::create(['occupation' => 'Construction Trades']);
		Occupation::create(['occupation' => 'Education, Teaching & Training']);
		Occupation::create(['occupation' => 'Engineering & Engineering Technicians']);
		Occupation::create(['occupation' => 'Fishing, Farming & Forestry']);
		Occupation::create(['occupation' => 'Health & Medical']);
		Occupation::create(['occupation' => 'Hospitality, Travel & Tourism']);
		Occupation::create(['occupation' => 'Media Communications & Broadcasting']);
		Occupation::create(['occupation' => 'Military & Armed Forces']);
		Occupation::create(['occupation' => 'Office Administration & Management']);
		Occupation::create(['occupation' => 'Production & Manufacturing']);
		Occupation::create(['occupation' => 'Professional & Service']);
		Occupation::create(['occupation' => 'Psychology & Counseling']);
		Occupation::create(['occupation' => 'Installation, Repair & Maintenance']);
		Occupation::create(['occupation' => 'Sales & Marketing']);
		Occupation::create(['occupation' => 'Social & Life Sciences']);
		Occupation::create(['occupation' => 'Transportation & Moving']);
	}

}


class CountriesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('countries')->delete();

		Country	::	create	(['country'	=>		'Afghanistan	']);
Country	::	create	(['country'	=>		'Aland	']);
Country	::	create	(['country'	=>		'Albania	']);
Country	::	create	(['country'	=>		'Algeria	']);
Country	::	create	(['country'	=>		'American Samoa	']);
Country	::	create	(['country'	=>		'Andorra	']);
Country	::	create	(['country'	=>		'Angola	']);
Country	::	create	(['country'	=>		'Anguilla	']);
Country	::	create	(['country'	=>		'Antarctica	']);
Country	::	create	(['country'	=>		'Antigua and Barbuda	']);
Country	::	create	(['country'	=>		'Argentina	']);
Country	::	create	(['country'	=>		'Armenia	']);
Country	::	create	(['country'	=>		'Aruba	']);
Country	::	create	(['country'	=>		'Australia	']);
Country	::	create	(['country'	=>		'Austria	']);
Country	::	create	(['country'	=>		'Azerbaijan	']);
Country	::	create	(['country'	=>		'Bahamas	']);
Country	::	create	(['country'	=>		'Bahrain	']);
Country	::	create	(['country'	=>		'Bangladesh	']);
Country	::	create	(['country'	=>		'Barbados	']);
Country	::	create	(['country'	=>		'Belarus	']);
Country	::	create	(['country'	=>		'Belgium	']);
Country	::	create	(['country'	=>		'Belize	']);
Country	::	create	(['country'	=>		'Benin	']);
Country	::	create	(['country'	=>		'Bermuda	']);
Country	::	create	(['country'	=>		'Bhutan	']);
Country	::	create	(['country'	=>		'Bolivia	']);
Country	::	create	(['country'	=>		'Bonaire	']);
Country	::	create	(['country'	=>		'Bosnia and Herzegovina	']);
Country	::	create	(['country'	=>		'Botswana	']);
Country	::	create	(['country'	=>		'Bouvet Island	']);
Country	::	create	(['country'	=>		'Brazil	']);
Country	::	create	(['country'	=>		'British Indian Ocean Territory	']);
Country	::	create	(['country'	=>		'British Virgin Islands	']);
Country	::	create	(['country'	=>		'Brunei	']);
Country	::	create	(['country'	=>		'Bulgaria	']);
Country	::	create	(['country'	=>		'Burkina Faso	']);
Country	::	create	(['country'	=>		'Burundi	']);
Country	::	create	(['country'	=>		'Cambodia	']);
Country	::	create	(['country'	=>		'Cameroon	']);
Country	::	create	(['country'	=>		'Canada	']);
Country	::	create	(['country'	=>		'Cape Verde	']);
Country	::	create	(['country'	=>		'Cayman Islands	']);
Country	::	create	(['country'	=>		'Central African Republic	']);
Country	::	create	(['country'	=>		'Chad	']);
Country	::	create	(['country'	=>		'Chile	']);
Country	::	create	(['country'	=>		'China	']);
Country	::	create	(['country'	=>		'Christmas Island	']);
Country	::	create	(['country'	=>		'Cocos [Keeling] Islands	']);
Country	::	create	(['country'	=>		'Colombia	']);
Country	::	create	(['country'	=>		'Comoros	']);
Country	::	create	(['country'	=>		'Cook Islands	']);
Country	::	create	(['country'	=>		'Costa Rica	']);
Country	::	create	(['country'	=>		'Croatia	']);
Country	::	create	(['country'	=>		'Cuba	']);
Country	::	create	(['country'	=>		'Curacao	']);
Country	::	create	(['country'	=>		'Cyprus	']);
Country	::	create	(['country'	=>		'Czech Republic	']);
Country	::	create	(['country'	=>		'Democratic Republic of the Congo	']);
Country	::	create	(['country'	=>		'Denmark	']);
Country	::	create	(['country'	=>		'Djibouti	']);
Country	::	create	(['country'	=>		'Dominica	']);
Country	::	create	(['country'	=>		'Dominican Republic	']);
Country	::	create	(['country'	=>		'East Timor	']);
Country	::	create	(['country'	=>		'Ecuador	']);
Country	::	create	(['country'	=>		'Egypt	']);
Country	::	create	(['country'	=>		'El Salvador	']);
Country	::	create	(['country'	=>		'Equatorial Guinea	']);
Country	::	create	(['country'	=>		'Eritrea	']);
Country	::	create	(['country'	=>		'Estonia	']);
Country	::	create	(['country'	=>		'Ethiopia	']);
Country	::	create	(['country'	=>		'Falkland Islands	']);
Country	::	create	(['country'	=>		'Faroe Islands	']);
Country	::	create	(['country'	=>		'Fiji	']);
Country	::	create	(['country'	=>		'Finland	']);
Country	::	create	(['country'	=>		'France	']);
Country	::	create	(['country'	=>		'French Guiana	']);
Country	::	create	(['country'	=>		'French Polynesia	']);
Country	::	create	(['country'	=>		'French Southern Territories	']);
Country	::	create	(['country'	=>		'Gabon	']);
Country	::	create	(['country'	=>		'Gambia	']);
Country	::	create	(['country'	=>		'Georgia	']);
Country	::	create	(['country'	=>		'Germany	']);
Country	::	create	(['country'	=>		'Ghana	']);
Country	::	create	(['country'	=>		'Gibraltar	']);
Country	::	create	(['country'	=>		'Greece	']);
Country	::	create	(['country'	=>		'Greenland	']);
Country	::	create	(['country'	=>		'Grenada	']);
Country	::	create	(['country'	=>		'Guadeloupe	']);
Country	::	create	(['country'	=>		'Guam	']);
Country	::	create	(['country'	=>		'Guatemala	']);
Country	::	create	(['country'	=>		'Guernsey	']);
Country	::	create	(['country'	=>		'Guinea	']);
Country	::	create	(['country'	=>		'Guinea-Bissau	']);
Country	::	create	(['country'	=>		'Guyana	']);
Country	::	create	(['country'	=>		'Haiti	']);
Country	::	create	(['country'	=>		'Heard Island and McDonald Islands	']);
Country	::	create	(['country'	=>		'Honduras	']);
Country	::	create	(['country'	=>		'Hong Kong	']);
Country	::	create	(['country'	=>		'Hungary	']);
Country	::	create	(['country'	=>		'Iceland	']);
Country	::	create	(['country'	=>		'India	']);
Country	::	create	(['country'	=>		'Indonesia	']);
Country	::	create	(['country'	=>		'Iran	']);
Country	::	create	(['country'	=>		'Iraq	']);
Country	::	create	(['country'	=>		'Ireland	']);
Country	::	create	(['country'	=>		'Isle of Man	']);
Country	::	create	(['country'	=>		'Israel	']);
Country	::	create	(['country'	=>		'Italy	']);
Country	::	create	(['country'	=>		'Ivory Coast	']);
Country	::	create	(['country'	=>		'Jamaica	']);
Country	::	create	(['country'	=>		'Japan	']);
Country	::	create	(['country'	=>		'Jersey	']);
Country	::	create	(['country'	=>		'Jordan	']);
Country	::	create	(['country'	=>		'Kazakhstan	']);
Country	::	create	(['country'	=>		'Kenya	']);
Country	::	create	(['country'	=>		'Kiribati	']);
Country	::	create	(['country'	=>		'Kosovo	']);
Country	::	create	(['country'	=>		'Kuwait	']);
Country	::	create	(['country'	=>		'Kyrgyzstan	']);
Country	::	create	(['country'	=>		'Laos	']);
Country	::	create	(['country'	=>		'Latvia	']);
Country	::	create	(['country'	=>		'Lebanon	']);
Country	::	create	(['country'	=>		'Lesotho	']);
Country	::	create	(['country'	=>		'Liberia	']);
Country	::	create	(['country'	=>		'Libya	']);
Country	::	create	(['country'	=>		'Liechtenstein	']);
Country	::	create	(['country'	=>		'Lithuania	']);
Country	::	create	(['country'	=>		'Luxembourg	']);
Country	::	create	(['country'	=>		'Macao	']);
Country	::	create	(['country'	=>		'Macedonia	']);
Country	::	create	(['country'	=>		'Madagascar	']);
Country	::	create	(['country'	=>		'Malawi	']);
Country	::	create	(['country'	=>		'Malaysia	']);
Country	::	create	(['country'	=>		'Maldives	']);
Country	::	create	(['country'	=>		'Mali	']);
Country	::	create	(['country'	=>		'Malta	']);
Country	::	create	(['country'	=>		'Marshall Islands	']);
Country	::	create	(['country'	=>		'Martinique	']);
Country	::	create	(['country'	=>		'Mauritania	']);
Country	::	create	(['country'	=>		'Mauritius	']);
Country	::	create	(['country'	=>		'Mayotte	']);
Country	::	create	(['country'	=>		'Mexico	']);
Country	::	create	(['country'	=>		'Micronesia	']);
Country	::	create	(['country'	=>		'Moldova	']);
Country	::	create	(['country'	=>		'Monaco	']);
Country	::	create	(['country'	=>		'Mongolia	']);
Country	::	create	(['country'	=>		'Montenegro	']);
Country	::	create	(['country'	=>		'Montserrat	']);
Country	::	create	(['country'	=>		'Morocco	']);
Country	::	create	(['country'	=>		'Mozambique	']);
Country	::	create	(['country'	=>		'Myanmar [Burma]	']);
Country	::	create	(['country'	=>		'Namibia	']);
Country	::	create	(['country'	=>		'Nauru	']);
Country	::	create	(['country'	=>		'Nepal	']);
Country	::	create	(['country'	=>		'Netherlands	']);
Country	::	create	(['country'	=>		'New Caledonia	']);
Country	::	create	(['country'	=>		'New Zealand	']);
Country	::	create	(['country'	=>		'Nicaragua	']);
Country	::	create	(['country'	=>		'Niger	']);
Country	::	create	(['country'	=>		'Nigeria	']);
Country	::	create	(['country'	=>		'Niue	']);
Country	::	create	(['country'	=>		'Norfolk Island	']);
Country	::	create	(['country'	=>		'North Korea	']);
Country	::	create	(['country'	=>		'Northern Mariana Islands	']);
Country	::	create	(['country'	=>		'Norway	']);
Country	::	create	(['country'	=>		'Oman	']);
Country	::	create	(['country'	=>		'Pakistan	']);
Country	::	create	(['country'	=>		'Palau	']);
Country	::	create	(['country'	=>		'Palestine	']);
Country	::	create	(['country'	=>		'Panama	']);
Country	::	create	(['country'	=>		'Papua New Guinea	']);
Country	::	create	(['country'	=>		'Paraguay	']);
Country	::	create	(['country'	=>		'Peru	']);
Country	::	create	(['country'	=>		'Philippines	']);
Country	::	create	(['country'	=>		'Pitcairn Islands	']);
Country	::	create	(['country'	=>		'Poland	']);
Country	::	create	(['country'	=>		'Portugal	']);
Country	::	create	(['country'	=>		'Puerto Rico	']);
Country	::	create	(['country'	=>		'Qatar	']);
Country	::	create	(['country'	=>		'Republic of the Congo	']);
Country	::	create	(['country'	=>		'Reunion	']);
Country	::	create	(['country'	=>		'Romania	']);
Country	::	create	(['country'	=>		'Russia	']);
Country	::	create	(['country'	=>		'Rwanda	']);
Country	::	create	(['country'	=>		'Saint Bartholemy	']);
Country	::	create	(['country'	=>		'Saint Helena	']);
Country	::	create	(['country'	=>		'Saint Kitts and Nevis	']);
Country	::	create	(['country'	=>		'Saint Lucia	']);
Country	::	create	(['country'	=>		'Saint Martin	']);
Country	::	create	(['country'	=>		'Saint Pierre and Miquelon	']);
Country	::	create	(['country'	=>		'Saint Vincent and the Grenadines	']);
Country	::	create	(['country'	=>		'Samoa	']);
Country	::	create	(['country'	=>		'San Marino	']);
Country	::	create	(['country'	=>		'Sao Tome Principe	']);
Country	::	create	(['country'	=>		'Saudi Arabia	']);
Country	::	create	(['country'	=>		'Senegal	']);
Country	::	create	(['country'	=>		'Serbia	']);
Country	::	create	(['country'	=>		'Seychelles	']);
Country	::	create	(['country'	=>		'Sierra Leone	']);
Country	::	create	(['country'	=>		'Singapore	']);
Country	::	create	(['country'	=>		'Sint Maarten	']);
Country	::	create	(['country'	=>		'Slovakia	']);
Country	::	create	(['country'	=>		'Slovenia	']);
Country	::	create	(['country'	=>		'Solomon Islands	']);
Country	::	create	(['country'	=>		'Somalia	']);
Country	::	create	(['country'	=>		'South Africa	']);
Country	::	create	(['country'	=>		'South Georgia and the South Sandwich Islands	']);
Country	::	create	(['country'	=>		'South Korea']);
Country	::	create	(['country'	=>		'South Sudan	']);
Country	::	create	(['country'	=>		'Spain	']);
Country	::	create	(['country'	=>		'Sri Lanka']);
Country	::	create	(['country'	=>		'Sudan	']);
Country	::	create	(['country'	=>		'Suriname	']);
Country	::	create	(['country'	=>		'Svalbard and Jan Mayen	']);
Country	::	create	(['country'	=>		'Swaziland	']);
Country	::	create	(['country'	=>		'Sweden'	]);
Country	::	create	(['country'	=>		'Switzerland	']);
Country	::	create	(['country'	=>		'Syria	']);
Country	::	create	(['country'	=>		'Taiwan	']);
Country	::	create	(['country'	=>		'Tajikistan	']);
Country	::	create	(['country'	=>		'Tanzania	']);
Country	::	create	(['country'	=>		'Thailand	']);
Country	::	create	(['country'	=>		'Togo	']);
Country	::	create	(['country'	=>		'Tokelau	']);
Country	::	create	(['country'	=>		'Tonga	']);
Country	::	create	(['country'	=>		'Trinidad and Tobago	']);
Country	::	create	(['country'	=>		'Tunisia	']);
Country	::	create	(['country'	=>		'Turkey	']);
Country	::	create	(['country'	=>		'Turkmenistan	']);
Country	::	create	(['country'	=>		'Turks and Caicos Islands	']);
Country	::	create	(['country'	=>		'Tuvalu	']);
Country	::	create	(['country'	=>		'U.S. Minor Outlying Islands	']);
Country	::	create	(['country'	=>		'U.S. Virgin Islands	']);
Country	::	create	(['country'	=>		'Uganda	']);
Country	::	create	(['country'	=>		'Ukraine	']);
Country	::	create	(['country'	=>		'United Arab Emirates	']);
Country	::	create	(['country'	=>		'United Kingdom	']);
Country	::	create	(['country'	=>		'United States	']);
Country	::	create	(['country'	=>		'Uruguay	']);
Country	::	create	(['country'	=>		'Uzbekistan	']);
Country	::	create	(['country'	=>		'Vanuatu	']);
Country	::	create	(['country'	=>		'Vatican City	']);
Country	::	create	(['country'	=>		'Venezuela	']);
Country	::	create	(['country'	=>		'Vietnam	']);
Country	::	create	(['country'	=>		'Wallis and Futuna	']);
Country	::	create	(['country'	=>		'Western Sahara	']);
Country	::	create	(['country'	=>		'Yemen	']);
Country	::	create	(['country'	=>		'Zambia	']);
Country	::	create	(['country'	=>		'Zimbabwe	']);


	}

}