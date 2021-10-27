<?php

namespace App\Console\Commands;

use Exception;
use Faker\Factory;
use App\Utilities\Constant;
use App\Services\UserService;
use Illuminate\Console\Command;
use App\Exceptions\ApiException;
use App\Services\SubscriberService;
use App\Services\WebsiteService;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will install the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->info("Started ...");

            $this->install();
            $this->dummy_data();

            $this->info("Finished ...");
        } catch (ApiException $e) {
            $this->error($e->getMessage());
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function install()
    {
        $this->info("migration started ...");
        Artisan::call("migrate:fresh", ["--force" => true]);
        $this->info("migration finished ...");
    }

    public function dummy_data()
    {
        $this->info("inserting dummy data ...");
        $faker = Factory::create();

        for($i=0; $i<Constant::get("dummy_count"); $i++) {
            SubscriberService::add($faker->email, $faker->name, "http://".$faker->domainName);
        }

        $this->info("dummy data done ...");
    }
}
