<?php

namespace Tests\Unit;

use App\Http\ValidationRules\UniqueUserRule;
use Modules\Core\Models\Staff;
use App\Models\Account;
use App\Models\Company;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @test
 * @covers  App\Utils\NumberHelper
 */
class UniqueEmailTest extends TestCase
{
    use InteractsWithDatabase;

    protected $rule;

    public function setUp()
    {
        parent::setUp();

        if (! config('ninja.db.multi_db_enabled'))
            $this->markTestSkipped('Multi DB not enabled - skipping');

         DB::connection('db-ninja-01')->table('users')->delete();
         DB::connection('db-ninja-02')->table('users')->delete();

        $this->rule = new UniqueUserRule();

        $ac = factory(\App\Models\Account::class)->make();

        $account = Account::on('db-ninja-01')->create($ac->toArray());
        $account2 = Account::on('db-ninja-02')->create($ac->toArray());

        $company = factory(\App\Models\Company::class)->make([
            'account_id' => $account->id,
        ]);

        $company2 = factory(\App\Models\Company::class)->make([
            'account_id' => $account2->id,
        ]);

        Company::on('db-ninja-01')->create($company->toArray());
        Company::on('db-ninja-02')->create($company2->toArray());


        $user = [
            'first_name' => 'user_db_1',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'db' => config('database.default'),
            'account_id' => $account->id,
        ];

        $user2 = [
            'first_name' => 'user_db_2',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'db' => config('database.default'),
            'account_id' => $account2->id,
        ];

        User::on('db-ninja-01')->create($user);
        User::on('db-ninja-02')->create($user2);

    }

    public function test_unique_emails_detected_on_database()
    {

        $this->assertFalse($this->rule->passes('email', 'user@example.com'));

    }

    public function test_no_unique_emails_detected()
    {

        $this->assertTrue($this->rule->passes('email', 'nohit@example.com'));

    }

    public function tearDown()
    {
        DB::connection('db-ninja-01')->table('users')->delete();
        DB::connection('db-ninja-02')->table('users')->delete();
    }

}