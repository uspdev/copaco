<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;
use App\Providers\AuthServiceProvider;
use App\User;
use Mockery;

class AuthServiceProviderTest extends TestCase
{
    public function testGateAdminNoAdmin()
    {
        config(['copaco.superadmins_ids' => '']);
        config(['copaco.superadmins_senhaunica' => '']);
        config(['copaco.superadmins_ldap' => '']);
        $user = Mockery::mock(new User);
        $user->id = 6431176;
        $this->actingAs($user);
        $this->assertFalse(Gate::allows('admin'));
    }
    
    public function testGateAdminNoAdminID()
    {
        config(['copaco.superadmins_ids' => '']);
        config(['copaco.superadmins_senhaunica' => '314159']);
        config(['copaco.superadmins_ldap' => '265358']);
        $user = Mockery::mock(new User);
        $user->id = 6431176;
        $this->actingAs($user);
        $this->assertFalse(Gate::allows('admin'));
    }
    
    public function testGateAdminNoAdminSenhaUnica()
    {
        config(['copaco.superadmins_ids' => '314159']);
        config(['copaco.superadmins_senhaunica' => '']);
        config(['copaco.superadmins_ldap' => '265358']);
        $user = Mockery::mock(new User);
        $user->id = 6431176;
        $this->actingAs($user);
        $this->assertFalse(Gate::allows('admin'));
    }
    
    public function testGateAdminNoAdminLDAP()
    {
        config(['copaco.superadmins_ids' => '314159']);
        config(['copaco.superadmins_senhaunica' => '265358']);
        config(['copaco.superadmins_ldap' => '']);
        $user = Mockery::mock(new User);
        $user->id = 6431176;
        $this->actingAs($user);
        $this->assertFalse(Gate::allows('admin'));
    }
    
    public function testGateAdminWrongID()
    {
        config(['copaco.superadmins_ids' => '314159']);
        config(['copaco.superadmins_senhaunica' => '265358']);
        config(['copaco.superadmins_ldap' => '979323']);
        $user = Mockery::mock(new User);
        $user->id = 6431176;
        $this->actingAs($user);
        $this->assertFalse(Gate::allows('admin'));
    }
    
    public function testGateAdminID()
    {
        config(['copaco.superadmins_ids' => '6431176']);
        config(['copaco.superadmins_senhaunica' => '']);
        config(['copaco.superadmins_ldap' => '']);
        $user = Mockery::mock(new User);
        $user->id = 6431176;
        $this->actingAs($user);
        $this->assertTrue(Gate::allows('admin'));
    }
}

?>
