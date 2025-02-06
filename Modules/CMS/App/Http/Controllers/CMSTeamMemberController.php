<?php

namespace Modules\CMS\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Services\ArticleDataService;
use App\Services\ArticleLangDataService;
use App\Services\ArticleService;
use App\Services\LanguageService;
use App\Services\TeamMemberService;
use App\Traits\ChecksPermissionTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\CMS\App\Http\Requests\TeamMemberContentRequest;
use Modules\CMS\DataTables\TeamMemberTable;

class CMSTeamMemberController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * CMSTeamMemberController constructor
     *
     */
    public function __construct(
        private ArticleService $articleService,
        private ArticleDataService $articleDataService,
        private ArticleLangDataService $articleLangDataService,
        private TeamMemberService $teamMemberService,
        private LanguageService $languageService,
    ) {
        $this->mapActionPermission = [
            'index' => PermissionMenuEnum::CMS_TEAM_MEMBER->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index(TeamMemberTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Team Member'),
            'description' => localize('Team Member'),
        ]);

        $languages        = $this->languageService->activeLanguages();
        $teamMemberBanner = $this->articleService->teamMemberBanner();
        $teamHeader       = $this->articleService->teamHeader();

        return $dataTable->render('cms::team-member.index', compact('languages', 'teamMemberBanner', 'teamHeader'));
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  TeamMemberContentRequest  $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(TeamMemberContentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $teamMember = $this->teamMemberService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Team Member Content create successfully"),
            'title'   => localize("Team Member Content"),
            'data'    => $teamMember,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $teamMemberId
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $teamMemberId): JsonResponse
    {
        $teamMember = $this->teamMemberService->findOrFail($teamMemberId);

        return response()->json([
            'success' => true,
            'message' => localize("Team Member Content Data"),
            'title'   => localize("Team Member Content"),
            'data'    => $teamMember,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeamMemberContentRequest  $request
     * @param  int  $languageId
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(TeamMemberContentRequest $request, int $teamMemberId): JsonResponse
    {
        $data                   = $request->validated();
        $data['team_member_id'] = $teamMemberId;

        $teamMember = $this->teamMemberService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Team Member Content update successfully"),
            'title'   => localize("Team Member Content"),
            'data'    => $teamMember,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->teamMemberService->destroy(['team_member_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Team Member Content delete successfully"),
            'title'   => localize("Team Member Content"),
        ]);

    }

}
