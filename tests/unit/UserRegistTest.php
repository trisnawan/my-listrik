<?php
namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\UserModel;

class UserRegistTest extends CIUnitTestCase{
    public function regist(){
        $model = new UserModel();
        $model->insert([
            'email' => 'test@example.com',
            'password' => 'katasandi',
            'full_name' => 'Test User'
        ]);

        $user = $model->findByEmail('test@example.com');
        $this->assertIsArray($user);
        $this->assertEquals('test@example.com', $user['email']);
    }
}