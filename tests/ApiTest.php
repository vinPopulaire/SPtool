<?php
use \Laracasts\Integrated\Services\Laravel\DatabaseTransactions;

class ApiTest extends TestCase {

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = \App\User::first();
        $this->be($user);
    }

    /** @test */
    public function mecanexusers_returns_a_json()
    {
        $this->get('/api/v1/mecanexuser')
             ->seeJsonContains(['name'=>'Mecan']);

    }

    /** @test */
    public function it_updates_a_user()
    {
        $this->put('/api/v1/mecanexuser/whatever',['name' => 'NewName'])
             ->verifyInDatabase('mecanex_users',['name'=>'NewName']);
    }

    /** @test */
    public function it_deletes_a_user()
    {
        $this->delete('/api/v1/mecanexuser/whatever')
            ->seeJsonEquals(["message"=>"User deleted"]);
    }

    /** @test */
    public function age_returns_a_json()
    {
        $this->get('/api/v1/age')
             ->seeJsonKey('Age List');
    }
    
    /** @test */
    public function countries_returns_a_json()
    {
        $this->get('/api/v1/countries')
             ->seeJsonKey('Country List');
    }

    /** @test */
    public function genders_returns_a_json()
    {
        $this->get('/api/v1/genders')
            ->seeJsonKey('Gender List');
    }

    /** @test */
    public function occupations_returns_a_json()
    {
        $this->get('/api/v1/occupations')
            ->seeJsonKey('Occupations List');
    }

    /** @test */
    public function education_returns_a_json()
    {
        $this->get('/api/v1/education')
            ->seeJsonKey('Education List');
    }

    /** @test */
    public function actions_returns_a_json()
    {
        $this->get('/api/v1/actions')
            ->seeJsonKey('Actions List');
    }

    /** @test */
    public function it_shows_interests_of_a_user()
    {
        $this->get('/api/v1/interest/mecanex')
            ->seeJsonKey('arts');
    }
    
    /** @test */
    public function it_stores_a_new_interest_to_user()
    {
        $this->post('/api/v1/interest',['username'=>'mecanex','arts'=>'2','disasters'=>'3','education'=>'1','environment'=>'2','health'=>'5','lifestyle'=>'2','media'=>'2','holidays'=>'5','politics'=>'2','religion'=>'1','society'=>'4','transportation'=>'3','wars'=>'2','work'=>'1'])
             ->verifyInDatabase('users_interests_scores',['mecanex_user_id'=>'1','interest_id'=>'1','interest_score'=>'2']);
    }

    /** @test */
    public function it_updates_some_interests_of_the_user()
    {
        $this->put('/api/v1/interest/mecanex',['arts'=>'2','health'=>'5'])
            ->verifyInDatabase('users_interests_scores',['mecanex_user_id'=>'1','interest_id'=>'1','interest_score'=>'2']);
    }

    /** @test */
    public function it_returns_recommended_videos()
    {
        $this->get('/api/v1/search/mecanex')
            ->seeJsonKey('Video Ids');
    }

}