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
             ->verifyInDatabase('users_interests_scores',['mecanex_user_id'=>'2','interest_id'=>'1','interest_score'=>'2']);
    }

    /** @test */
    public function it_updates_some_interests_of_the_user()
    {
        $this->put('/api/v1/interest/mecanex',['arts'=>'2','health'=>'5'])
            ->verifyInDatabase('users_interests_scores',['mecanex_user_id'=>'2','interest_id'=>'1','interest_score'=>'2']);
    }

    /** @test */
    public function it_returns_recommended_videos()
    {
        $this->get('/api/v1/search/mecanex')
            ->seeJsonKey('Video Ids');
    }

    /** @test */
    public function signal_start_video_writes_to_database()
    {
        $this->post('/api/v1/videosignals',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'1'])
            ->verifyInDatabase('user_actions',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'1']);
    }
    
    /** @test */
    public function signal_stop_video_fails_when_video_not_started()
    {
        $this->post('/api/v1/videosignals',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'2'])
            ->seeStatusCode(404);
    }

    /** @test */
    public function signal_stop_video_writes_to_database()
    {
        $this->post('/api/v1/videosignals',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'1','duration'=>'10']);
        $this->post('/api/v1/videosignals',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'2','duration'=>'10'])
            ->verifyInDatabase('user_actions',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'2']);
        $this->seeStatusCode(200);
    }

    /** @test */
    public function signal_click_enrichment_writes_to_database()
    {
        $this->post('/api/v1/videosignals',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'3'])
            ->verifyInDatabase('user_actions',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'3'])
            ->seeStatusCode(200);
    }

    /** @test */
    public function signal_share_enrichment_writes_to_database()
    {
        $this->post('/api/v1/videosignals',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'5'])
            ->verifyInDatabase('user_actions',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'5'])
            ->seeStatusCode(200);
    }

    /** @test */
    public function signal_explicitrf_succeeds()
    {
        $this->post('/api/v1/videosignals',['username'=>'mecanex','video_id'=>'EUS_0036129F1AC58CDF5F3BE9BFA05CE671','device_id'=>'5ef687e8-7b01-4737-8229-3a64ffe778f2','action'=>'6','value'=>10])
            ->seeStatusCode(200);
    }
}