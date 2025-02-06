<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Repositories\Eloquent\TeamMemberRepository;
use App\Repositories\Interfaces\TeamMemberRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class TeamMemberService
{
    /**
     * TeamMemberService constructor.
     *
     */
    public function __construct(
        protected TeamMemberRepositoryInterface $teamMemberRepository,
    ) {
    }

    /**
     * Find team member or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findOrFail(int $id): object
    {
        return $this->teamMemberRepository->findOrFail($id);
    }

    /**
     * Create Team Member
     *
     * @param  array  $attributes
     * @return object
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        $attributes['avatar'] = ImageHelper::upload($attributes['avatar'], 'team-member');

        try {
            DB::beginTransaction();

            $teamMember = $this->teamMemberRepository->create($attributes);

            DB::commit();

            return $teamMember;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Team Member create error"),
                'title'   => localize("Team Member"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update Team Member
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $teamMemberId         = $attributes['team_member_id'];
        $teamMember           = $this->teamMemberRepository->findOrFail($teamMemberId);
        $attributes['avatar'] = ImageHelper::upload($attributes['avatar'] ?? null, 'team-member', $teamMember->avatar);

        try {
            DB::beginTransaction();

            $this->teamMemberRepository->updateById($teamMemberId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Team Member update error"),
                'title'   => localize("Team Member"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete Team Member
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $teamMemberId = $attributes['team_member_id'];

        try {
            DB::beginTransaction();

            $teamMember = $this->teamMemberRepository->findOrFail($teamMemberId);

            if ($teamMember && $teamMember->avatar) {
                delete_file('public/' . $teamMember->avatar);
            }

            $this->teamMemberRepository->destroyById($teamMemberId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Team Member delete error"),
                'title'   => localize("Team Member"),
            ], 422));
        }

    }

}
