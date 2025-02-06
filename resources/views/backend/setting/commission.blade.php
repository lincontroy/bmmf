<x-app-layout>
    <x-setting activeMenu="commission-setup" activeMenuTitle="{{ localize('Commission Setup') }}">
        <div class="card-body px-4 px-xl-5">
            <form action="{{ route('admin.setting.commission_store') }}" method="post"
                  class="needs-validation" data-resetvalue="false" data="showCallBackData" id="commission-setting-form" novalidate=""
                  data-insert="{{ route('admin.setting.commission_store') }}" enctype="multipart/form-data">
                @csrf
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="table-responsive">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th>
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="fee">{{ localize('Level') }} <span class="text-danger">*</span>
                         </label>
                            </th>
                            <th>
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="fee">{{ localize('Personal Investment') }} <span class="text-danger">*</span>
                         </label>
                            </th>
                            <th>
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="fee">{{ localize('Total investment') }} <span class="text-danger">*</span>
                         </label>
                            </th>
                            <th>
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="fee">{{ localize('Team Bonus') }} <span class="text-danger">*</span>
                         </label>
                            </th>
                            <th>
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                               for="fee">{{ localize('Referral Bonus') }}% <span class="text-danger">*</span>
                        </label>
                            </th>
                        </tr>
                        @foreach($commissions as $key => $commission)
                        <tr>
                            <td><input type="number" name="level[]" id="level_{{ $key }}" readonly value="{{ $commission->level_name }}"
                                class="bg-transparent custom-form-control form-control @error('level') is-invalid @enderror"
                                placeholder="{{ localize('Level') }}" required/>
                         <div class="invalid-feedback d-block" role="alert">
                             @if ($errors->has('level.' . $key))
                                 <div class="error">{{ $errors->first('level.' . $key) }}</div>
                             @endif
                         </div>
                        </td>
                            <td>
                                <input type="number" name="personal_invest[]" value="{{ $commission->personal_invest }}"
                                   class="bg-transparent custom-form-control form-control @error('personal_invest') is-invalid @enderror"
                                   placeholder="{{ localize('Personal Investment') }}"/>
                            <div class="invalid-feedback d-block" role="alert">
                                @if ($errors->has('personal_invest.' . $key))
                                    <div class="error">{{ $errors->first('personal_invest.' . $key) }}</div>
                                @endif
                            </div>
                            </td>
                            <td>
                                <input type="number" name="total_invest[]" value="{{ $commission->total_invest }}"
                                class="bg-transparent custom-form-control form-control @error('total_invest') is-invalid @enderror"
                                placeholder="{{ localize('Total investment') }}" required/>
                         <div class="invalid-feedback d-block" role="alert">
                             @if ($errors->has('total_invest.' . $key))
                                 <div class="error">{{ $errors->first('total_invest.' . $key) }}</div>
                             @endif
                         </div>
                            </td>
                            <td>
                                <input type="number" name="team_bonus[]" value="{{ $commission->team_bonus }}"
                                class="bg-transparent custom-form-control form-control @error('team_bonus') is-invalid @enderror"
                                placeholder="{{ localize('Team Bonus') }}" required/>
                         <div class="invalid-feedback d-block" role="alert">
                             @if ($errors->has('team_bonus.' . $key))
                                 <div class="error">{{ $errors->first('team_bonus.' . $key) }}</div>
                             @endif
                         </div>
                            </td>
                            <td>
                                <input type="number" name="referral_bonus[]" value="{{ $commission->referral_bonus }}"
                                class="bg-transparent custom-form-control form-control @error('referral_bonus') is-invalid @enderror"
                                placeholder="{{ localize('Referral Bonus') }}" required/>
                         <div class="invalid-feedback d-block" role="alert">
                             @if ($errors->has('referral_bonus.' . $key))
                                 <div class="error">{{ $errors->first('referral_bonus.' . $key) }}</div>
                             @endif
                         </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                </div>
                <div class="col-lg-10 text-end">
                    <button type="submit" class="actionBtn btn btn-save py-2 px-5"
                            id="commissionBtn">{{ localize('update') }}</button>
                </div>
            </div>
        </form>
        </div>
    </x-setting>
    @push('js')
        <script src="{{ assets('js/setting/commission.js') }}"></script>
    @endpush
</x-app-layout>
