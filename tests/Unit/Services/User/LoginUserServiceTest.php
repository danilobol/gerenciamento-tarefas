<?php

namespace Tests\Unit\Services\User;

use App\DTOs\User\AuthUserDTO;
use App\DTOs\User\LoginUserDTO;
use App\Services\User\LoginUserService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Mockery;

class LoginUserServiceTest extends TestCase
{
    private const string FAKE_JWT_TOKEN = 'fake.jwt.token';
    private const string EMAIL_USER = 'user@example.com';
    private const string PASSWORD_USER = 'password123';
    private const int TLL_MINUTES = 60;

    public function test_login_success_returns_auth_user_dto(): void
    {
        $user = Mockery::mock(Authenticatable::class)
            ->shouldIgnoreMissing()
            ->allows(['getAuthIdentifierName' => 'id', 'getAuthIdentifier' => 1]);

        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => self::EMAIL_USER, 'password' => self::PASSWORD_USER])
            ->andReturn(self::FAKE_JWT_TOKEN);

        Auth::shouldReceive('user')
            ->andReturn($user);

        $factoryMock = Mockery::mock();
        $factoryMock->shouldReceive('getTTL')
            ->andReturn(self::TLL_MINUTES);

        Auth::shouldReceive('factory')
            ->andReturn($factoryMock);

        $service = new LoginUserService();
        $result = $service->execute(new LoginUserDTO(self::EMAIL_USER, self::PASSWORD_USER));

        $this->assertInstanceOf(AuthUserDTO::class, $result);
        $this->assertEquals(self::FAKE_JWT_TOKEN, $result->token);
        $this->assertEquals(self::TLL_MINUTES * 60000, $result->expiresIn);
        $this->assertInstanceOf(Authenticatable::class, $result->user);
    }

    public function test_login_invalid_credentials_throws_exception(): void
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => self::EMAIL_USER, 'password' => self::PASSWORD_USER])
            ->andReturn(false);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unauthorized user!');

        $service = new LoginUserService();
        $service->execute(new LoginUserDTO(self::EMAIL_USER, self::PASSWORD_USER));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
