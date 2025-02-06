<div class="modal fade" id="userInfo" tabindex="-1" aria-labelledby="userInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">{{ localize('User Profile') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <table>
                    <tbody>
                    <tr>
                        <th>{{ localize('Name') }}</th>
                        <td class="px-2">:</td>
                        <td id="name"></td>
                    </tr>
                    <tr>
                        <th>{{ localize('Email') }}</th>
                        <td class="px-2">:</td>
                        <td id="email"></td>
                    </tr>
                    <tr>
                        <th>{{ localize('Mobile') }}</th>
                        <td class="px-2">:</td>
                        <td id="phone"></td>
                    </tr>
                    <tr>
                        <th>{{ localize('User ID') }}</th>
                        <td class="px-2">:</td>
                        <td id="user_id"></td>
                    </tr>
                    </tbody>
                </table>
                <span class="payoutInfo"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ localize('Close') }}</button>
            </div>
        </div>
    </div>
</div>
