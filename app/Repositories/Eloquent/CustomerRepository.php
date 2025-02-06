<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    /**
     * Base query
     *
     * @param  array  $attributes
     * @return Builder
     */
    private function baseQuery(array $attributes = []): Builder
    {
        $query = $this->model->newQuery();

        if (isset($attributes['user_id'])) {
            $query = $query->where('user_id', $attributes['user_id']);
        }

        if (isset($attributes['phone'])) {
            $query = $query->where('phone', $attributes['phone']);
        }

        if (isset($attributes['email'])) {
            $query = $query->where('email', $attributes['email']);
        }

        if (isset($attributes['verified_status'])) {
            $query = $query->where('verified_status', $attributes['verified_status']);
        }

        if (isset($attributes['merchant_verified_status'])) {
            $query = $query->where('merchant_verified_status', $attributes['merchant_verified_status']);
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * @inheritDoc
     */
    public function customerCreate(array $attributes): object
    {

        do {
            $randomString = strtoupper(Str::random(8));
        } while ($this->modelExists('user_id', $randomString));

        $data['first_name']               = $attributes['first_name'];
        $data['last_name']                = $attributes['last_name'];
        $data['phone']                    = $attributes['phone'];
        $data['email']                    = $attributes['email'];
        $data['username']                 = $attributes['email'];
        $data['user_id']                  = $randomString;
        $data['password']                 = Hash::make($attributes['password']);
        $data['status']                   = $attributes['status'];
        $data['created_at']               = Carbon::now();
        $data['email_verification_token'] = sha1(time());

        if (isset($attributes['referral'])) {
            $data['referral_user'] = $attributes['referral'];
        }

        return $this->model->create($data);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {

        do {
            $randomString = strtoupper(Str::random(8));
        } while ($this->modelExists('user_id', $randomString));

        $data                             = $this->fillable($attributes);
        $data['user_id']                  = $randomString;
        $data['password']                 = Hash::make($attributes['password']);
        $data['status']                   = StatusEnum::INACTIVE->value;
        $data['created_at']               = Carbon::now();
        $data['email_verification_token'] = sha1(time());

        if (isset($attributes['referral'])) {
            $data['referral_user'] = $attributes['referral'];
        }

        return $this->model->create($data);
    }

    /**
     * Fillable attributes
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        return [
            'first_name' => $attributes['first_name'],
            'last_name'  => $attributes['last_name'],
            'username'   => $attributes['username'],
            'email'      => $attributes['email'],
            'phone'      => $attributes['phone'],
            'country'    => $attributes['country'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function findByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->with($relations)->first();
    }

    /**
     * @inheritDoc
     */
    public function getByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->with($relations)->get();
    }

    /**
     * @inheritDoc
     */
    public function updateVerifyStatusById(int $id, array $attributes): bool
    {
        $data                    = [];
        $data['verified_status'] = $attributes['verified_status'];
        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateSiteAlignById(int $id, array $attributes): bool
    {
        $data               = [];
        $data['site_align'] = $attributes['site_align'];

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = [];

        if (isset($attributes['password']) && $attributes['password'] != null) {
            $data['password'] = Hash::make($attributes['password']);
        }

        $data['first_name']    = $attributes['first_name'];
        $data['last_name']     = $attributes['last_name'];
        $data['referral_user'] = $attributes['referral_user'];
        $data['status']        = $attributes['status'];
        $data['email']         = $attributes['email'];
        $data['phone']         = $attributes['phone'];

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateAvatar(int $id, ?string $avatar): bool
    {
        $data           = [];
        $data['avatar'] = $avatar;

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateCustomerInformation(int $id, array $attributes): bool
    {
        $data = [
            'email'      => $attributes['email'],
            'first_name' => $attributes['first_name'],
            'last_name'  => $attributes['last_name'],
            'phone'      => $attributes['phone'],
            'country'    => $attributes['country'],
            'state'      => $attributes['state'],
            'city'       => $attributes['city'],
            'address'    => $attributes['address'],
            'language'   => $attributes['language'],
        ];

        if (isset($attributes['referral_user'])) {
            $data['referral_user'] = $attributes['referral_user'];
        }

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updatePassword(int $id, string $password): bool
    {
        $data             = [];
        $data['password'] = Hash::make($password);

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function addGoogle2faAuth(int $id, string $secretKey): bool
    {
        $data                     = [];
        $data['google2fa_secret'] = $secretKey;
        $data['google2fa_enable'] = 1;

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function removeGoogle2faAuth(int $id): bool
    {
        $data                     = [];
        $data['google2fa_secret'] = null;
        $data['google2fa_enable'] = 0;

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateLastLogin(int $id, array $attributes): bool
    {
        $data               = [];
        $data['last_login'] = $attributes['last_login'];
        $data['visitor']    = $attributes['visitor'];

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateLastLogout(int $id, array $attributes): bool
    {
        $data                = [];
        $data['last_logout'] = $attributes['last_logout'];

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateVerifiedStatus(int $id, array $attributes): bool
    {
        $data                    = [];
        $data['verified_status'] = $attributes['verified_status'];

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function activateCustomer(int $id, array $attributes): bool
    {
        $data           = [];
        $data['status'] = $attributes['status'];

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateMerchantVerifiedStatus(int $id, int $merchantVerifiedStatus): bool
    {
        $data                             = [];
        $data['merchant_verified_status'] = $merchantVerifiedStatus;

        return parent::updateById($id, $data);
    }

    /**
     * Count current month customers
     * @return int
     */
    public function countCurrentMonthCustomer(): int
    {
        return Customer::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
    }

    /**
     * Count previous month customers
     * @return int
     */
    public function countPreviousMonthCustomer(): int
    {
        return Customer::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();
    }

    /**
     * Count Recent 12 months data
     * @return array
     */
    public function countYearlyCustomer(): array
    {
        $recent12MonthsCustomers = [];
        $currentMonth            = Carbon::now()->month;
        $currentYear             = Carbon::now()->year;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $count = Customer::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();

            $recent12MonthsCustomers[] = $count;
        }

        return $recent12MonthsCustomers;
    }

    /**
     * Find Customer
     *
     * @param array $attributes
     * @return object|null
     */
    public function findCustomer(array $attributes): ?object
    {
        return $this->model->where('user_id', $attributes['user'])
            ->orWhere('email', $attributes['user'])->first();
    }

    /**
     * Get Generation
     *
     * @param [type] $userId
     * @return void
     */
    public function getGeneration($userId)
    {
        $query = $this->model::with(['investments', 'sponsoredUsers.sponsoredUsers.sponsoredUsers.sponsoredUsers'])
            ->where('user_id', $userId)
            ->get();

        $data = [];

        $this->traverseLevels($query, $data);

        return $data;
    }

    /**
     * Traverse Levels
     *
     * @param [type] $users
     * @param [type] $data
     * @param integer $level
     * @return void
     */
    private function traverseLevels($users, &$data, $level = 1)
    {

        foreach ($users as $user) {
            $userData = [
                'level'      => $level,
                'user_id'    => $user->user_id,
                'username'   => $user->username,
                'name'       => $user->first_name . ' ' . $user->last_name,
                'sponsor_id' => $user->referral_user,
                'amount'     => $user->investments->sum('total_invest_amount'),
            ];

            $data[] = $userData;

            if ($user->sponsoredUsers->isNotEmpty() && $level < 6) {
                $this->traverseLevels($user->sponsoredUsers, $data, $level + 1);
            }

        }

    }

}
