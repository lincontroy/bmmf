<?php

namespace Modules\CMS\App\Http\Requests;

use App\Enums\StatusEnum;
use App\Models\Article;
use App\Models\TeamMember;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamMemberContentRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Article id
     *
     * @var int|null
     */
    private ?int $teamMemberId;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $uniqueRule = Rule::unique(TeamMember::class, 'id');
        $statues    = StatusEnum::values();
        $imageRule  = "required";

        if (!empty($this->teamMemberId)) {
            $uniqueRule = $uniqueRule->ignore($this->teamMemberId);
            $imageRule  = "nullable";
        }

        return [
            "name"        => ["required", "string"],
            "designation" => ["required", "string"],
            'avatar'      => [$imageRule, 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            "status"      => ["required", "string", 'in:' . implode(',', $statues)],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->teamMemberId = $this->route('team_member');
    }

}
