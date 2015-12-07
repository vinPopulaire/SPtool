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
use App\Term;
use App\Interest;
use App\Action;


class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();



	//	$this->call('MecanexUsersTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('GenderTableSeeder');
		$this->call('AgeTableSeeder');
		$this->call('TermSeeder');
		$this->call('OccupationTableSeeder');
		$this->call('CountriesTableSeeder');
		$this->call('EducationTableSeeder');
		//$this->call('UsersTermsScoresSeeder');
		$this->call('InterestsSeeder');
		$this->call('ActionsSeeder');
		$this->command->info('Tables seeded!');
	}

}


class GenderTableSeeder extends Seeder {

	public function run()
	{
		DB::table('gender')->delete();

		Gender::create(['id'=>'1','gender' => 'Male']);
		Gender::create(['id'=>'2','gender' => 'Female']);
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
	User::create(array(

		'email' => 'vci@mail.com',
		'username' => 'vci',
		'password' => Hash::make("mecanex"),

	));

	User::create(array(

		'email' => 'noterik@mail.com',
		'username' => 'noterik',
		'password' => Hash::make("noterik"),

	));

}

}


//class MecanexUsersTableSeeder extends Seeder {
//
//	public function run()
//	{
//		DB::table('mecanex_users')->delete();
//
//		MecanexUser::create(array(
//			'username' => 'skafetzo',
//			'name' => 'Stella',
//			'surname' => 'Kafetzoglou',
//			'gender_id'=>'2',
//			'age_id'=>'5',
//			'education_id'=>'5',
//			'occupation_id'=>'5',
//			'country_id'=>'87'
//		));
//		MecanexUser::create(array(
//			'username' => 'vassilis',
//			'name' => 'Vassilis',
//			'surname' => 'Merekoulias',
//			'gender_id'=>'1',
//			'age_id'=>'4',
//			'education_id'=>'4',
//			'occupation_id'=>'5',
//			'country_id'=>'75'
//		));
//		MecanexUser::create(array(
//			'username' => 'testing',
//			'name' => 'Joe',
//			'surname' => 'Doe',
//			'gender_id'=>'2',
//			'age_id'=>'3',
//			'education_id'=>'2',
//			'occupation_id'=>'2',
//			'country_id'=>'6'
//		));
//	}
//
//}



class AgeTableSeeder extends Seeder {

	public function run()
	{
		DB::table('ages')->delete();

		Age::create(['id'=>'1','age' => 'Under 12']);
		Age::create(['id'=>'2','age' => '12-17']);
		Age::create(['id'=>'3','age' => '18-24']);
		Age::create(['id'=>'4','age' => '25-34']);
		Age::create(['id'=>'5','age' => '35-44']);
		Age::create(['id'=>'6','age' => '45-54']);
		Age::create(['id'=>'7','age' => '55-64']);
		Age::create(['id'=>'8','age' => '65-74']);
		Age::create(['id'=>'9','age' => '75 older']);
	}

}


class TermSeeder extends Seeder {

	public function run()
	{
		DB::table('terms')->delete();

		Term::create(['id'=>'1','term' => 'arts']);
		Term::create(['id'=>'2','term' => 'disasters']);
		Term::create(['id'=>'3','term' => 'education']);
		Term::create(['id'=>'4','term' => 'environment']);
		Term::create(['id'=>'5','term' => 'health']);
		Term::create(['id'=>'6','term' => 'lifestyle']);
		Term::create(['id'=>'7','term' => 'media']);
		Term::create(['id'=>'8','term' => 'holidays']);
		Term::create(['id'=>'9','term' => 'politics']);
		Term::create(['id'=>'10','term' => 'religion']);
		Term::create(['id'=>'11','term' => 'society']);
		Term::create(['id'=>'12','term' => 'transportation']);
		Term::create(['id'=>'13','term' => 'wars']);
		Term::create(['id'=>'14','term' => 'work']);
	}

}

//class UsersTermsScoresSeeder extends Seeder {
//
//	public function run()
//	{
//		DB::table('users_terms_scores')->delete();
//
//		DB::table('users_terms_scores')->insert(array(
//			array('mecanex_user_id' => 1, 'profile_term_id' => 1, 'user_score'=>9),
//			array('mecanex_user_id' => 1, 'profile_term_id' => 2, 'user_score'=>7),
//			array('mecanex_user_id' => 1, 'profile_term_id' => 3, 'user_score'=>3),
//			array('mecanex_user_id' => 2, 'profile_term_id' => 1, 'user_score'=>1),
//			array('mecanex_user_id' => 2, 'profile_term_id' => 2, 'user_score'=>8),
//			array('mecanex_user_id' => 2, 'profile_term_id' => 3, 'user_score'=>6),
////			array('mecanex_user_id' => 1, 'profile_term_id' => 4, 'score'=>9),
////			array('mecanex_user_id' => 1, 'profile_term_id' => 5, 'score'=>7),
////			array('mecanex_user_id' => 1, 'profile_term_id' => 6, 'score'=>3),
////			array('mecanex_user_id' => 1, 'profile_term_id' => 7, 'score'=>0),
////			array('mecanex_user_id' => 1, 'profile_term_id' => 8, 'score'=>2),
////			array('mecanex_user_id' => 1, 'profile_term_id' => 9, 'score'=>1),
////			array('mecanex_user_id' => 1, 'profile_term_id' => 10, 'score'=>3),
//
//		));
//	}
//
//}


class InterestsSeeder extends Seeder {

	public function run()
	{
		DB::table('interests')->delete();

		Interest::create(['id'=>'1','interest' => 'Arts and culture','short_name'=>'arts']);
		Interest::create(['id'=>'2','interest' => 'Disasters','short_name'=>'disasters']);
		Interest::create(['id'=>'3','interest' => 'Education','short_name'=>'education']);
		Interest::create(['id'=>'4','interest' => 'Environment and nature','short_name'=>'environment']);
		Interest::create(['id'=>'5','interest' => 'Health','short_name'=>'health']);
		Interest::create(['id'=>'6','interest' => 'Lifestyle and consumerism','short_name'=>'lifestyle']);
		Interest::create(['id'=>'7','interest' => 'The Media','short_name'=>'media']);
		Interest::create(['id'=>'8','interest' => 'National holidays, festivals, anniversaries, annual events','short_name'=>'holidays']);
		Interest::create(['id'=>'9','interest' => 'Politics and economics','short_name'=>'politics']);
		Interest::create(['id'=>'10','interest' => 'Religion and belief','short_name'=>'religion']);
		Interest::create(['id'=>'11','interest' => 'Society and social issues','short_name'=>'society']);
		Interest::create(['id'=>'12','interest' => 'Transportation, science and technology','short_name'=>'transportation']);
		Interest::create(['id'=>'13','interest' => 'Wars and conflict','short_name'=>'wars']);
		Interest::create(['id'=>'14','interest' => 'Work and production','short_name'=>'work']);

	}

}

class EducationTableSeeder extends Seeder {

	public function run()
	{
		DB::table('education')->delete();

		Education::create(['id'=>'1','education' => 'Basic']);
		Education::create(['id'=>'2','education' => 'High School Diploma']);
		Education::create(['id'=>'3','education' => 'Bachelor Degree']);
		Education::create(['id'=>'4','education' => 'Master Degree']);
		Education::create(['id'=>'5','education' => 'Doctoral Degree']);

	}

}

class OccupationTableSeeder extends Seeder {

	public function run()
	{
		DB::table('occupations')->delete();

		Occupation::create(['id'=>'1','occupation' => 'Business & Finance']);
		Occupation::create(['id'=>'2','occupation' => 'Computers & Technology']);
		Occupation::create(['id'=>'3','occupation' => 'Construction Trades']);
		Occupation::create(['id'=>'4','occupation' => 'Education, Teaching & Training']);
		Occupation::create(['id'=>'5','occupation' => 'Engineering & Engineering Technicians']);
		Occupation::create(['id'=>'6','occupation' => 'Fishing, Farming & Forestry']);
		Occupation::create(['id'=>'7','occupation' => 'Health & Medical']);
		Occupation::create(['id'=>'8','occupation' => 'Hospitality, Travel & Tourism']);
		Occupation::create(['id'=>'9','occupation' => 'Media Communications & Broadcasting']);
		Occupation::create(['id'=>'10','occupation' => 'Military & Armed Forces']);
		Occupation::create(['id'=>'11','occupation' => 'Office Administration & Management']);
		Occupation::create(['id'=>'12','occupation' => 'Production & Manufacturing']);
		Occupation::create(['id'=>'13','occupation' => 'Professional & Service']);
		Occupation::create(['id'=>'14','occupation' => 'Psychology & Counseling']);
		Occupation::create(['id'=>'15','occupation' => 'Installation, Repair & Maintenance']);
		Occupation::create(['id'=>'16','occupation' => 'Sales & Marketing']);
		Occupation::create(['id'=>'17','occupation' => 'Social & Life Sciences']);
		Occupation::create(['id'=>'18','occupation' => 'Transportation & Moving']);
	}

}


class ActionsSeeder extends Seeder {

	public function run()
	{
		DB::table('actions')->delete();

		Action::create(['id'=>'1','action' => 'play video', 'importance'=>'0.6']);
		Action::create(['id'=>'2','action' => 'stop video','importance'=>'0.6']);
		Action::create(['id'=>'3','action' => 'click enrichment','importance'=>'0.2']);
		Action::create(['id'=>'4','action' => 'click ad','importance'=>'0.2']);
		Action::create(['id'=>'5','action' => 'share','importance'=>'0.2']);
		Action::create(['id'=>'6','action' => 'explicit_rf','importance'=>'1']);
	}

}



class CountriesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('countries')->delete();

		Country	::	create	(['id'=>'1','country'	=>		'Afghanistan	']);
Country	::	create	(['id'=>'2','country'	=>		'Aland	']);
Country	::	create	(['id'=>'3','country'	=>		'Albania	']);
Country	::	create	(['id'=>'4','country'	=>		'Algeria	']);
Country	::	create	(['id'=>'5','country'	=>		'American Samoa	']);
Country	::	create	(['id'=>'6','country'	=>		'Andorra	']);
Country	::	create	(['id'=>'7','country'	=>		'Angola	']);
Country	::	create	(['id'=>'8','country'	=>		'Anguilla	']);
Country	::	create	(['id'=>'9','country'	=>		'Antarctica	']);
Country	::	create	(['id'=>'10','country'	=>		'Antigua and Barbuda	']);
Country	::	create	(['id'=>'11','country'	=>		'Argentina	']);
Country	::	create	(['id'=>'12','country'	=>		'Armenia	']);
Country	::	create	(['id'=>'13','country'	=>		'Aruba	']);
Country	::	create	(['id'=>'14','country'	=>		'Australia	']);
Country	::	create	(['id'=>'15','country'	=>		'Austria	']);
Country	::	create	(['id'=>'16','country'	=>		'Azerbaijan	']);
Country	::	create	(['id'=>'17','country'	=>		'Bahamas	']);
Country	::	create	(['id'=>'18','country'	=>		'Bahrain	']);
Country	::	create	(['id'=>'19','country'	=>		'Bangladesh	']);
Country	::	create	(['id'=>'20','country'	=>		'Barbados	']);
Country	::	create	(['id'=>'21','country'	=>		'Belarus	']);
Country	::	create	(['id'=>'22','country'	=>		'Belgium	']);
Country	::	create	(['id'=>'23','country'	=>		'Belize	']);
Country	::	create	(['id'=>'24','country'	=>		'Benin	']);
Country	::	create	(['id'=>'25','country'	=>		'Bermuda	']);
Country	::	create	(['id'=>'26','country'	=>		'Bhutan	']);
Country	::	create	(['id'=>'27','country'	=>		'Bolivia	']);
Country	::	create	(['id'=>'28','country'	=>		'Bonaire	']);
Country	::	create	(['id'=>'29','country'	=>		'Bosnia and Herzegovina	']);
Country	::	create	(['id'=>'30','country'	=>		'Botswana	']);
Country	::	create	(['id'=>'31','country'	=>		'Bouvet Island	']);
Country	::	create	(['id'=>'32','country'	=>		'Brazil	']);
Country	::	create	(['id'=>'33','country'	=>		'British Indian Ocean Territory	']);
Country	::	create	(['id'=>'34','country'	=>		'British Virgin Islands	']);
Country	::	create	(['id'=>'35','country'	=>		'Brunei	']);
Country	::	create	(['id'=>'36','country'	=>		'Bulgaria	']);
Country	::	create	(['id'=>'37','country'	=>		'Burkina Faso	']);
Country	::	create	(['id'=>'38','country'	=>		'Burundi	']);
Country	::	create	(['id'=>'39','country'	=>		'Cambodia	']);
Country	::	create	(['id'=>'40','country'	=>		'Cameroon	']);
Country	::	create	(['id'=>'41','country'	=>		'Canada	']);
Country	::	create	(['id'=>'42','country'	=>		'Cape Verde	']);
Country	::	create	(['id'=>'43','country'	=>		'Cayman Islands	']);
Country	::	create	(['id'=>'44','country'	=>		'Central African Republic	']);
Country	::	create	(['id'=>'45','country'	=>		'Chad	']);
Country	::	create	(['id'=>'46','country'	=>		'Chile	']);
Country	::	create	(['id'=>'47','country'	=>		'China	']);
Country	::	create	(['id'=>'48','country'	=>		'Christmas Island	']);
Country	::	create	(['id'=>'49','country'	=>		'Cocos [Keeling] Islands	']);
Country	::	create	(['id'=>'50','country'	=>		'Colombia	']);
Country	::	create	(['id'=>'51','country'	=>		'Comoros	']);
Country	::	create	(['id'=>'52','country'	=>		'Cook Islands	']);
Country	::	create	(['id'=>'53','country'	=>		'Costa Rica	']);
Country	::	create	(['id'=>'54','country'	=>		'Croatia	']);
Country	::	create	(['id'=>'55','country'	=>		'Cuba	']);
Country	::	create	(['id'=>'56','country'	=>		'Curacao	']);
Country	::	create	(['id'=>'57','country'	=>		'Cyprus	']);
Country	::	create	(['id'=>'58','country'	=>		'Czech Republic	']);
Country	::	create	(['id'=>'59','country'	=>		'Democratic Republic of the Congo	']);
Country	::	create	(['id'=>'60','country'	=>		'Denmark	']);
Country	::	create	(['id'=>'61','country'	=>		'Djibouti	']);
Country	::	create	(['id'=>'62','country'	=>		'Dominica	']);
Country	::	create	(['id'=>'63','country'	=>		'Dominican Republic	']);
Country	::	create	(['id'=>'64','country'	=>		'East Timor	']);
Country	::	create	(['id'=>'65','country'	=>		'Ecuador	']);
Country	::	create	(['id'=>'66','country'	=>		'Egypt	']);
Country	::	create	(['id'=>'67','country'	=>		'El Salvador	']);
Country	::	create	(['id'=>'68','country'	=>		'Equatorial Guinea	']);
Country	::	create	(['id'=>'69','country'	=>		'Eritrea	']);
Country	::	create	(['id'=>'70','country'	=>		'Estonia	']);
Country	::	create	(['id'=>'71','country'	=>		'Ethiopia	']);
Country	::	create	(['id'=>'72','country'	=>		'Falkland Islands	']);
Country	::	create	(['id'=>'73','country'	=>		'Faroe Islands	']);
Country	::	create	(['id'=>'74','country'	=>		'Fiji	']);
Country	::	create	(['id'=>'75','country'	=>		'Finland	']);
Country	::	create	(['id'=>'76','country'	=>		'France	']);
Country	::	create	(['id'=>'77','country'	=>		'French Guiana	']);
Country	::	create	(['id'=>'78','country'	=>		'French Polynesia	']);
Country	::	create	(['id'=>'79','country'	=>		'French Southern Territories	']);
Country	::	create	(['id'=>'80','country'	=>		'Gabon	']);
Country	::	create	(['id'=>'81','country'	=>		'Gambia	']);
Country	::	create	(['id'=>'82','country'	=>		'Georgia	']);
Country	::	create	(['id'=>'83','country'	=>		'Germany	']);
Country	::	create	(['id'=>'84','country'	=>		'Ghana	']);
Country	::	create	(['id'=>'85','country'	=>		'Gibraltar	']);
Country	::	create	(['id'=>'86','country'	=>		'Greece	']);
Country	::	create	(['id'=>'87','country'	=>		'Greenland	']);
Country	::	create	(['id'=>'88','country'	=>		'Grenada	']);
Country	::	create	(['id'=>'89','country'	=>		'Guadeloupe	']);
Country	::	create	(['id'=>'90','country'	=>		'Guam	']);
Country	::	create	(['id'=>'91','country'	=>		'Guatemala	']);
Country	::	create	(['id'=>'92','country'	=>		'Guernsey	']);
Country	::	create	(['id'=>'93','country'	=>		'Guinea	']);
Country	::	create	(['id'=>'94','country'	=>		'Guinea-Bissau	']);
Country	::	create	(['id'=>'95','country'	=>		'Guyana	']);
Country	::	create	(['id'=>'96','country'	=>		'Haiti	']);
Country	::	create	(['id'=>'97','country'	=>		'Heard Island and McDonald Islands	']);
Country	::	create	(['id'=>'98','country'	=>		'Honduras	']);
Country	::	create	(['id'=>'99','country'	=>		'Hong Kong	']);
Country	::	create	(['id'=>'100','country'	=>		'Hungary	']);
Country	::	create	(['id'=>'101','country'	=>		'Iceland	']);
Country	::	create	(['id'=>'102','country'	=>		'India	']);
Country	::	create	(['id'=>'103','country'	=>		'Indonesia	']);
Country	::	create	(['id'=>'104','country'	=>		'Iran	']);
Country	::	create	(['id'=>'105','country'	=>		'Iraq	']);
Country	::	create	(['id'=>'106','country'	=>		'Ireland	']);
Country	::	create	(['id'=>'107','country'	=>		'Isle of Man	']);
Country	::	create	(['id'=>'108','country'	=>		'Israel	']);
Country	::	create	(['id'=>'109','country'	=>		'Italy	']);
Country	::	create	(['id'=>'110','country'	=>		'Ivory Coast	']);
Country	::	create	(['id'=>'111','country'	=>		'Jamaica	']);
Country	::	create	(['id'=>'112','country'	=>		'Japan	']);
Country	::	create	(['id'=>'113','country'	=>		'Jersey	']);
Country	::	create	(['id'=>'114','country'	=>		'Jordan	']);
Country	::	create	(['id'=>'115','country'	=>		'Kazakhstan	']);
Country	::	create	(['id'=>'116','country'	=>		'Kenya	']);
Country	::	create	(['id'=>'117','country'	=>		'Kiribati	']);
Country	::	create	(['id'=>'118','country'	=>		'Kosovo	']);
Country	::	create	(['id'=>'119','country'	=>		'Kuwait	']);
Country	::	create	(['id'=>'120','country'	=>		'Kyrgyzstan	']);
Country	::	create	(['id'=>'121','country'	=>		'Laos	']);
Country	::	create	(['id'=>'122','country'	=>		'Latvia	']);
Country	::	create	(['id'=>'123','country'	=>		'Lebanon	']);
Country	::	create	(['id'=>'124','country'	=>		'Lesotho	']);
Country	::	create	(['id'=>'125','country'	=>		'Liberia	']);
Country	::	create	(['id'=>'126','country'	=>		'Libya	']);
Country	::	create	(['id'=>'127','country'	=>		'Liechtenstein	']);
Country	::	create	(['id'=>'128','country'	=>		'Lithuania	']);
Country	::	create	(['id'=>'129','country'	=>		'Luxembourg	']);
Country	::	create	(['id'=>'130','country'	=>		'Macao	']);
Country	::	create	(['id'=>'131','country'	=>		'Macedonia	']);
Country	::	create	(['id'=>'132','country'	=>		'Madagascar	']);
Country	::	create	(['id'=>'133','country'	=>		'Malawi	']);
Country	::	create	(['id'=>'134','country'	=>		'Malaysia	']);
Country	::	create	(['id'=>'135','country'	=>		'Maldives	']);
Country	::	create	(['id'=>'136','country'	=>		'Mali	']);
Country	::	create	(['id'=>'137','country'	=>		'Malta	']);
Country	::	create	(['id'=>'138','country'	=>		'Marshall Islands	']);
Country	::	create	(['id'=>'139','country'	=>		'Martinique	']);
Country	::	create	(['id'=>'140','country'	=>		'Mauritania	']);
Country	::	create	(['id'=>'141','country'	=>		'Mauritius	']);
Country	::	create	(['id'=>'142','country'	=>		'Mayotte	']);
Country	::	create	(['id'=>'143','country'	=>		'Mexico	']);
Country	::	create	(['id'=>'144','country'	=>		'Micronesia	']);
Country	::	create	(['id'=>'145','country'	=>		'Moldova	']);
Country	::	create	(['id'=>'146','country'	=>		'Monaco	']);
Country	::	create	(['id'=>'147','country'	=>		'Mongolia	']);
Country	::	create	(['id'=>'148','country'	=>		'Montenegro	']);
Country	::	create	(['id'=>'149','country'	=>		'Montserrat	']);
Country	::	create	(['id'=>'150','country'	=>		'Morocco	']);
Country	::	create	(['id'=>'151','country'	=>		'Mozambique	']);
Country	::	create	(['id'=>'152','country'	=>		'Myanmar [Burma]	']);
Country	::	create	(['id'=>'153','country'	=>		'Namibia	']);
Country	::	create	(['id'=>'154','country'	=>		'Nauru	']);
Country	::	create	(['id'=>'155','country'	=>		'Nepal	']);
Country	::	create	(['id'=>'156','country'	=>		'Netherlands	']);
Country	::	create	(['id'=>'157','country'	=>		'New Caledonia	']);
Country	::	create	(['id'=>'158','country'	=>		'New Zealand	']);
Country	::	create	(['id'=>'159','country'	=>		'Nicaragua	']);
Country	::	create	(['id'=>'160','country'	=>		'Niger	']);
Country	::	create	(['id'=>'161','country'	=>		'Nigeria	']);
Country	::	create	(['id'=>'162','country'	=>		'Niue	']);
Country	::	create	(['id'=>'163','country'	=>		'Norfolk Island	']);
Country	::	create	(['id'=>'164','country'	=>		'North Korea	']);
Country	::	create	(['id'=>'165','country'	=>		'Northern Mariana Islands	']);
Country	::	create	(['id'=>'166','country'	=>		'Norway	']);
Country	::	create	(['id'=>'167','country'	=>		'Oman	']);
Country	::	create	(['id'=>'168','country'	=>		'Pakistan	']);
Country	::	create	(['id'=>'169','country'	=>		'Palau	']);
Country	::	create	(['id'=>'170','country'	=>		'Palestine	']);
Country	::	create	(['id'=>'171','country'	=>		'Panama	']);
Country	::	create	(['id'=>'172','country'	=>		'Papua New Guinea	']);
Country	::	create	(['id'=>'173','country'	=>		'Paraguay	']);
Country	::	create	(['id'=>'174','country'	=>		'Peru	']);
Country	::	create	(['id'=>'175','country'	=>		'Philippines	']);
Country	::	create	(['id'=>'176','country'	=>		'Pitcairn Islands	']);
Country	::	create	(['id'=>'177','country'	=>		'Poland	']);
Country	::	create	(['id'=>'178','country'	=>		'Portugal	']);
Country	::	create	(['id'=>'179','country'	=>		'Puerto Rico	']);
Country	::	create	(['id'=>'180','country'	=>		'Qatar	']);
Country	::	create	(['id'=>'181','country'	=>		'Republic of the Congo	']);
Country	::	create	(['id'=>'182','country'	=>		'Reunion	']);
Country	::	create	(['id'=>'183','country'	=>		'Romania	']);
Country	::	create	(['id'=>'184','country'	=>		'Russia	']);
Country	::	create	(['id'=>'185','country'	=>		'Rwanda	']);
Country	::	create	(['id'=>'186','country'	=>		'Saint Bartholemy	']);
Country	::	create	(['id'=>'187','country'	=>		'Saint Helena	']);
Country	::	create	(['id'=>'188','country'	=>		'Saint Kitts and Nevis	']);
Country	::	create	(['id'=>'189','country'	=>		'Saint Lucia	']);
Country	::	create	(['id'=>'190','country'	=>		'Saint Martin	']);
Country	::	create	(['id'=>'191','country'	=>		'Saint Pierre and Miquelon	']);
Country	::	create	(['id'=>'192','country'	=>		'Saint Vincent and the Grenadines	']);
Country	::	create	(['id'=>'193','country'	=>		'Samoa	']);
Country	::	create	(['id'=>'194','country'	=>		'San Marino	']);
Country	::	create	(['id'=>'195','country'	=>		'Sao Tome Principe	']);
Country	::	create	(['id'=>'196','country'	=>		'Saudi Arabia	']);
Country	::	create	(['id'=>'197','country'	=>		'Senegal	']);
Country	::	create	(['id'=>'198','country'	=>		'Serbia	']);
Country	::	create	(['id'=>'199','country'	=>		'Seychelles	']);
Country	::	create	(['id'=>'200','country'	=>		'Sierra Leone	']);
Country	::	create	(['id'=>'201','country'	=>		'Singapore	']);
Country	::	create	(['id'=>'202','country'	=>		'Sint Maarten	']);
Country	::	create	(['id'=>'203','country'	=>		'Slovakia	']);
Country	::	create	(['id'=>'204','country'	=>		'Slovenia	']);
Country	::	create	(['id'=>'205','country'	=>		'Solomon Islands	']);
Country	::	create	(['id'=>'206','country'	=>		'Somalia	']);
Country	::	create	(['id'=>'207','country'	=>		'South Africa	']);
Country	::	create	(['id'=>'208','country'	=>		'South Georgia and the South Sandwich Islands	']);
Country	::	create	(['id'=>'209','country'	=>		'South Korea']);
Country	::	create	(['id'=>'210','country'	=>		'South Sudan	']);
Country	::	create	(['id'=>'211','country'	=>		'Spain	']);
Country	::	create	(['id'=>'212','country'	=>		'Sri Lanka']);
Country	::	create	(['id'=>'213','country'	=>		'Sudan	']);
Country	::	create	(['id'=>'214','country'	=>		'Suriname	']);
Country	::	create	(['id'=>'215','country'	=>		'Svalbard and Jan Mayen	']);
Country	::	create	(['id'=>'216','country'	=>		'Swaziland	']);
Country	::	create	(['id'=>'217','country'	=>		'Sweden'	]);
Country	::	create	(['id'=>'218','country'	=>		'Switzerland	']);
Country	::	create	(['id'=>'219','country'	=>		'Syria	']);
Country	::	create	(['id'=>'220','country'	=>		'Taiwan	']);
Country	::	create	(['id'=>'221','country'	=>		'Tajikistan	']);
Country	::	create	(['id'=>'222','country'	=>		'Tanzania	']);
Country	::	create	(['id'=>'223','country'	=>		'Thailand	']);
Country	::	create	(['id'=>'224','country'	=>		'Togo	']);
Country	::	create	(['id'=>'225','country'	=>		'Tokelau	']);
Country	::	create	(['id'=>'226','country'	=>		'Tonga	']);
Country	::	create	(['id'=>'227','country'	=>		'Trinidad and Tobago	']);
Country	::	create	(['id'=>'228','country'	=>		'Tunisia	']);
Country	::	create	(['id'=>'229','country'	=>		'Turkey	']);
Country	::	create	(['id'=>'230','country'	=>		'Turkmenistan	']);
Country	::	create	(['id'=>'231','country'	=>		'Turks and Caicos Islands	']);
Country	::	create	(['id'=>'232','country'	=>		'Tuvalu	']);
Country	::	create	(['id'=>'233','country'	=>		'U.S. Minor Outlying Islands	']);
Country	::	create	(['id'=>'234','country'	=>		'U.S. Virgin Islands	']);
Country	::	create	(['id'=>'235','country'	=>		'Uganda	']);
Country	::	create	(['id'=>'236','country'	=>		'Ukraine	']);
Country	::	create	(['id'=>'237','country'	=>		'United Arab Emirates	']);
Country	::	create	(['id'=>'238','country'	=>		'United Kingdom	']);
Country	::	create	(['id'=>'239','country'	=>		'United States	']);
Country	::	create	(['id'=>'240','country'	=>		'Uruguay	']);
Country	::	create	(['id'=>'241','country'	=>		'Uzbekistan	']);
Country	::	create	(['id'=>'242','country'	=>		'Vanuatu	']);
Country	::	create	(['id'=>'243','country'	=>		'Vatican City	']);
Country	::	create	(['id'=>'244','country'	=>		'Venezuela	']);
Country	::	create	(['id'=>'245','country'	=>		'Vietnam	']);
Country	::	create	(['id'=>'246','country'	=>		'Wallis and Futuna	']);
Country	::	create	(['id'=>'247','country'	=>		'Western Sahara	']);
Country	::	create	(['id'=>'248','country'	=>		'Yemen	']);
Country	::	create	(['id'=>'249','country'	=>		'Zambia	']);
Country	::	create	(['id'=>'250','country'	=>		'Zimbabwe	']);


	}

}