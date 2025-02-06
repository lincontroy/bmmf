{{-- Group --}}
@foreach ($groups as $groupName => $groupData)
    <fieldset>
        <legend>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input module_group" type="checkbox" value="{{ $loop->iteration }}"
                    id="module_group_{{ $loop->iteration }}" />
                <label class="form-check-label" for="module_group_{{ $loop->iteration }}">{{ ucfirst_case($groupName) }}</label>
            </div>
        </legend>
        <div class="row g-3">
            {{-- Sub Group --}}
            @foreach ($groupData as $subGroup => $subGroupData)
                <fieldset>
                    <legend>
                        <div class="form-check form-switch mb-3">
                            {{ ucfirst_case($subGroup) }}
                        </div>
                    </legend>
                    <div class="row g-3">
                        {{-- Permission --}}
                        @forelse ($subGroupData as $permission)
                            <div class="col-6 col-sm-4">
                                <div class="form-check form-switch mb-3">
                                    <input
                                        class="form-check-input module_permissions_{{ $loop->parent->parent->iteration }}"
                                        name="permissions[]" type="checkbox" value="{{ $permission->id }}"
                                        id="permission_{{ $permission->id }}" />
                                    <label class="form-check-label fs-15 fw-normal"
                                        for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            </div>
                        @endforeach
                        {{-- Permission --}}
                    </div>
                </fieldset>
            @endforeach
            {{-- Sub Group --}}
        </div>
    </fieldset>
@endforeach
{{-- Group --}}
