<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthPersonalAccessClientsTable extends Migration
{
    /**
     * The database schema.
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Create a new migration instance.
     */
    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('oauth_personal_access_clients')) {
            $this->schema->create('oauth_personal_access_clients', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('client_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->schema->dropIfExists('oauth_personal_access_clients');
    }

    /**
     * Get the migration connection name.
     *
     * @return null|string
     */
    public function getConnection()
    {
        return config('passport.storage.database.connection');
    }
}
