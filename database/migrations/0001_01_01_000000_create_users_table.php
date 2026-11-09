Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');

    $table->enum('role', [
        'admin',
        'pengelola',
        'pengunjung'
    ])->default('pengunjung');

    $table->rememberToken();
    $table->timestamps();
});