@extends('layouts/layoutMaster')

@section('title', 'User - Dashboard')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
@endsection

@section('page-script')
    {{-- setting user details --}}
    <script>
        function setUserDetails(userId, userEmail) {
            document.getElementById('userId').value = userId;
            document.getElementById('userEmail').value = userEmail;
        }
    </script>

    {{-- UI for quotes --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quoteOverlay = document.getElementById('quoteOverlay');
            quoteOverlay.innerHTML = `<p class="quote-text">${randomQuote}</p>`;
        });
    </script>
@endsection

@section('content')

    @if (session('error'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000"
            style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="toast-header bg-danger text-white"
                style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <i class="ti ti-bell ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Error</div>
                <?php
                date_default_timezone_set('Asia/Kolkata');
                ?>
                <small class="text-muted"><?= date('h:i A') ?></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" style="padding: 10px; color: #333;">
                {{ session('error') }}
            </div>
        </div>

        <script>
            // Show toast message
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.querySelector('.toast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif

    @if (session('success'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000"
            style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="toast-header bg-success text-white"
                style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <i class="ti ti-bell ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Success</div>
                <?php
                date_default_timezone_set('Asia/Kolkata');
                ?>
                <small class="text-muted"><?= date(' h:i A') ?></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" style="padding: 10px; color: #333;">
                {{ session('success') }}
            </div>
        </div>

        <script>
            // Show toast message
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.querySelector('.toast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif

    @if ($errors && $errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card w-100 mt-4">

                <div class="user-profile-header-banner position-relative">
                    <img src="{{ asset('assets/img/pages/userbackground.webp') }}" alt="Banner image" class="rounded-top">
                    <div id="quoteOverlay" class="position-absolute top-50 start-50 translate-middle text-center"
                        style="font-size: 3rem; font-family: 'Segoe UI', sans-serif; color: #c5c3dc; text-shadow: 2px 2px 4px rgba(60, 46, 216, 0.71);">
                        <?php
                        $quotes = ['dream big', 'stay focused', 'never give up', 'work hard', 'believe', 'stay positive', 'keep smiling', 'keep going', 'you got this', 'fearless', 'take risks'];
                        
                        // Select a random quote from the array
                        $randomQuote = $quotes[array_rand($quotes)];
                        echo "<script>const randomQuote = \"$randomQuote\";</script>";
                        ?></div>
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-3">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ asset('assets/img/avatars/9.png') }}" alt="user image"
                            class="d-block ms-0 ms-sm-4 rounded rounded-circle user-profile-img mt-5 mb-1" height="auto">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info mt-3">
                                <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    @php
                                        if ($user->is_active == 1) {
                                            echo '<li class="list-inline-item">
                                  <i class="ti ti-toggle-right mb-1"></i>
                                  <small class="h6"> Active</small></li>';
                                        } else {
                                            echo '<li class="list-inline-item">
                                  <i class="ti ti-toggle-left mb-1"></i> <small class="h6"> Deactive</small>
                              </li>';
                                        }
                                    @endphp

                                </ul>
                            </div>
                            <div>
                                <a href="" data-bs-target="#addProfileModal" data-bs-toggle="modal"
                                    class="btn text-nowrap btn-primary" data-user-email="{{ $user->email }}"
                                    onclick="setUserDetails('{{ $user->id }}', '{{ $user->email }}')">
                                    <i class='ti ti-edit me-1'></i>Edit Profile
                                </a>
                                <a href="" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                    class="btn text-nowrap btn-primary reset-password-btn"
                                    data-user-email="{{ $user->email }}"
                                    onclick="setUserDetails('{{ $user->id }}', '{{ $user->email }}')">
                                    <i class='ti ti-edit me-1'></i>Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- About User -->
        <div class="col-md-6">
            <div class="card w-100 h-100 mt-2">
                <div class="card-body">
                    <small class="card-text text-uppercase">About</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-user"></i>
                            <span class="fw-bold mx-2">Full Name:</span>
                            <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-check"></i>
                            <span class="fw-bold mx-2">Status:</span>
                            <span>
                                @if ($user->is_active === 1)
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Deactive</span>
                                @endif
                            </span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-crown"></i>
                            <span class="fw-bold mx-2">Role:</span>
                            <span>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span>{{ $role->name }} </span>
                                    @endforeach
                                </td>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contact User -->
        <div class="col-md-6">
            <div class="card w-100 h-100 mt-2">
                <div class="card-body">
                    <small class="card-text text-uppercase">Contacts</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-phone-call"></i>
                            <span class="fw-bold mx-2">Contact:</span>
                            <span>{{ $user->phone_number }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-mail"></i>
                            <span class="fw-bold mx-2">Email:</span>
                            <span>{{ $user->email }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-home"></i>
                            <span class="fw-bold mx-2">Address:</span>
                            <span>{{ $user->address }}</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">Set New Password</h3>
                        <p class="text-muted">Set your new password</p>
                    </div>
                    <form method="POST" action="{{ route('user-reset-password') }}">
                        @csrf
                        <input type="hidden" name="id" id="userId" class="form-control">
                        <div class="mb-3 form-password-toggle">
                            <input type="hidden" name="email" id="email" class="form-control"
                                value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="current-password" class="form-label">Current Password</label>
                            <input id="current-password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                name="current_password" autocomplete="current-password">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('forgot-password-form') }}">
                                <small class="text-decoration-underline mb-5">Forgot Password ??</small>
                            </a>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                            <a href="{{ route('user-dashboard') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3 class="text-center">Edit Proile <img class="mb-1"
                            src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAoGBxERERERERERDxAQERMRDhEQFhASEBAQFhYYGBYSFhYaHysiGhwoHRQWIzQjKCwuMTExGSI3PDc8OyswPi8BCwsLDw4PHRERHTAoICgwMDAxMDAwMDAuMjAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMP/AABEIAOEA4QMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAABAUBAwYHAv/EAEsQAAEDAQMGBg8HAgQHAQAAAAEAAgMRBAVRBhIhMUFhExQWktHSByIyQ1JTVHFzgZGisbLCFTRCcoKhwSPwJFViYzM1g5PT4fFE/8QAGwEBAAIDAQEAAAAAAAAAAAAAAAQFAgMGAQf/xAAxEQACAQMBBgQGAgIDAAAAAAAAAQIDBBExBRIhUWGRFBVB4RMigbHi8HHRMlIGI6H/2gAMAwEAAhEDEQA/APZkREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAWqeZrGue9wYxoq5ziA1oxJWLTOyNjnvIYxgLnOdoAA2rzfKPKF9sfmtqyzsNWM1GQj8b/AOBs863UaMqssIj3NzChDel9EdDbcthUiCPPA/HJVoO8NGmnnoo8eVtorpZERhRw/eq56BupW132IyaArfwtCnHis/yc1LaN3Un8ksdFjB0N15TxyEMkHBPOgVNWE+fZ6/ar9ed22y5hIK6HJG9C8OheaujFWE6yzD1GnqIwUK5tYxj8Snp6ostnbSnUn8Gv/l6Pn0ft2OjREVeXYREQBERAERU1vvftzFFQuBpI/WGHwRifh8ALV8rW90Q3Cp1r5FqZifY7oUCxWaul1XOOsu0kqyYwBAfHGG7+a7oTjDd/Nd0LZRZogNXGG7+a7oTjDd/Nd0LbRKIDVxlu/wBjuhOMN3813QtlFmiA18O3fzXdCcO3fzXdC2URAa+Hbv8AY7oTh27/AGOWxEBr4Uf6vY5fXCDA+wr6RAYz9x9hWuadrGlzyGtGsu0AKNed6RwMLnnVsGsnALjb1vaW0Oq7tWfgjGpoxOLlCu72FvF+r5f2TLaynX4vhHn/AEVWVWVTrY8sbVlnjeQ1h0Oc9ppnSDYcG7POqyCULGU9zPJNps4/rNH9WLZaGD6wNR2jRhSnsF4NkbnNO5wOgtO0EbCrDZe1qdamsLGNVyfv6FNtTZU41Hl5zo+nL6cjqIJVZ2K3FmkGi5iy2pWMU66CMo1EczOnKnLqW1rtefpK25LTEWyAD8Re0+bMcfiAqV9oV1kDAZrUZfwQMOn/AHH9qBzc4+xa7iUYUZLozZZUpzuYy6o9CREVAdeEREAREQFLlbexs8HaGksruCixaT3T/UAfXRU1xsAAULsjWom1wR7I4s/1vcQf2jCl3PJoCA6eyuUwFVcEq3i0UQE5FB44nHQgJyKFx4Ypx5ATUULjwxQW0ICaiiC2BZFsCAlIoptYWma3b15k9SbJj5gFT3xfrYmkk0+JOAUG975DGkk6P3JwGJXLSSvmfwkmzuG7GjHz/wB+etvL5UlhaltZ2G/809DfPanzP4SSv+hmxu/zpGKrWFJskdSFzVWpKrLGS5worhwR9mM0XJZU5OuDjarKP6uuaEaBOPCH+v4r0C1cGGADXtVS8hbMzs6qnTf7yfQiOEbmDjNcP3ijgbutzZGhzT+YHQWnaCFaRWnQs5R5OuzzarKP6uuaHU2YYjB/xWvJ+7pbdIyOEEEisjnggQgGhL8CDUU1krt9lbRhWhlPTVcv30fqcdtTZ06ckms50fP35ky6rFNbJhDCNOuR57iJnhu/gbV6vcN0R2SFsMdSBpc490951vdv+AAGxYyfuSKxxCKIb5Hnu5H7XOP8bFZrZXruq+hnbW0aMeoREWgkhERAEREB5p2Rz/j2egj+eRTrldoCgdkr78z0EfzyKwuGOrQgLpslAtM9sopPFzRVV6SRQ1dNI2JmqryACcBidy9Sb0PG0uLMvvArWbxKrnZQWAd+HNk6FodlNYPHe7J0LP4U+Rj8SPMt/tErH2kVTOynsHjfdk6FrdlNYfG+7J0Lz4U+R78SHMvftRY+1t6512U9i8aObJ0LU/KSx+MPNf0Lx058jJTg/U6j7Y3rY2+BiuNflBZDqkPNf0LV9uWfZIfY7oWtxqL0Ztj8N+qO8beYO1RrfegY0uJ0f3oC5CO/4hqkJroAAcSTgNClte6Qhz9nct2N3+dVl5dOlHDXFlpZWsJvezlLkbnvdK7Pf+hvg7/P/fn2ALDQtgC5qpUlN5ZddFoZaFuZJmrTVa3yLXFtPKMWjfJaCdq0PtC0OeSt1lsznuaxgznu1D4knYN6k0reVR5Zg5paGyxWaWd7WMFS7UMBtJOwBd/ct1x2ZhZGBUnOlfQB0j6DtneqgG5asn7pbZ4/CkdThH47hgBgrGM6X7nD5QunsrOFBZxxf7g5+8unWe6nwX/ptREU4ghERAEREAREQHmnZH+/s9BH88ivcmoqhqo+yN9/Z6CP55F0GTDtDUB0jIQAvO8trtfJbzndw2Fhir3IBJDiN9W6fMF6SFCvK7IpwBI3OzdLHAua9uNHA12DRqNNK321ZUqm80RrujKtScIvDPLjcbdpPqotZuGPF/7L0U5JQH8U3PHQscj7P4U3PHQrHx9Hk+35FMtl3X+67/iecm4I8X+70L4NwRYye70L0jkdZ/Cm546E5G2fwpueOhPG2/J9vyMvLLr/AHXf8Tzb7Bhxk93oT7Ds41iT2joXpHI2z+HNzm9VfDsirOe+Tj1x9RYu9t/9X2/IyWzrr1mu/wCJ5426rGNbHHzup8Fm0WewsbogFdnbvcScKVXaXjkbY4mF8totLWjZWAlxwA4OpK5CS7IWTOdHwhaNDOELS4YntQBXzKDdbTo0Y5UVn91J1rsWvWazNpevtwI1mu5ocHlgafwtGkMHSrOJlFhjFuaFwl5dSr1XUl6ndW1vChTVOCwkZAQlYJWt71ESJBmSRaCaoXVX3BE5zgxgznu1D4k4BS6FDeZqlLJ92eFz3BjBnPdqH8k7Au3ycuVsLantnu0vcdu4YDctGT9ztiFT2z3Uz3Y7hgBgujjbQLo7S23PmepTXt1vfJDT7n0tNmOmT8/0tW5RrGdMnpPparAqyUiIgCIiAIiIAiIgPNOyP9/Z6CP55FdZOv0BUvZI+/s9BH88itbgPahAdhBJULaq2KSgWqe35qAt0quefexxXwb3KA6SqLmvtnetjL6GK8ye4OgLgFWXtfUcLC4nVqxJ2ADFVV4X4GNLidA+OC5ee1PmfnybO4Z4IxO/+/PAu71UlhallaWPxPnnp9yZeN5STuMkh/I3YwY+dV9Fl7qoFzlxXc+Gfcu4QS0XA+gFklYqvjO0iur+FFSybG8GHvWl7lukFRsHs/haWsL3BjRnOOoavOSdgGKnUbVy10I8qyMwROe4NYM5ztQ+JJ2AYrrbluxsQ09tI6me7E4DADBRLDBHA2lQ557t2JwA2Dcvp16UKvra1UOL1Ku5usrcjodRZXBTgVzFgvQE610FjmzgrBLBVyeTe5R7v756T6Wre/UVHu/vnpPpavTEloiIAiIgCIiAIiIDzTsj/f2egj+eRXOT0dWhU/ZG/wCYR+gi+eRdDky3Q1AXIs5ouVysvxlme2MMM0zhnCNpzQG6RnOOwVBx1LuAFxuV13ZtoNoLRmOY1pedTHNrocfwggihxrurItowlUSmRb2rOlRc4LLRzbspbWe5sLafnf8A+NanX5bz/wDhb/3HdVTHWyMapWc9vSvg3iNkzOczpVt4SnyOfW0rp8v36miO8LwcfuLKbpQfpWu0XlamCstmbHpp/wAUHDcpbb4cNUrf0ub0qJelkkkh42zOe2FxErBpPB0FZWjaWmtRhXBV97TpUKTk10S4lps64urisoZSWrePTuzEc73nOkoCO5aDUMGnTXHet3CquinDmh7HZzTpBCy2c1XEV4ybcs5yd5CWkWWbXal9B2reoMcq2h6hvgbtTeXUH9/3isNFfNRfDBVbZ3hjK63HQ1uqp/gYlSLag6kksfwa6tSMIuUnhLi2arVPmUaBnPcO0bjr0nAb1Js4kYykYZnOFXOcSCTp0aBqVdZw1pL3vaZHd0S5ooNjQK6AMFMZbWDvrOczpXe2Oy4UofOsy+3Y+f7S2xWq1P8ApeIru+vH7GJ5LYNLYbPIfSPB/dqrrRlDaYiBLZWtrg92kbu1oVbNvFvjmc5nSo9821j4HMdI14GlgBaTn7KAbVMlZx9EQae0a6fzPPY33XeTJmtljqNNHNOhzXDW0rvbikJaF53kXcU2a50jHRiV4c1rgQ7NAABIOqtPgvS7ps2Y0KmqpRm0tDpKbbgnLUmv1FR7v756T6WqS/UVGu/vnpPpasDIloiIAiIgCIiAIiIDzXsjff2egj+eRX+TT9DVz/ZH+/s9BH88iuMnn6AgOxBWVos8uhbc8YoDOaMAscG3wR7AmeMVmq8wMke1FkbHPLW9qK6hUnYPWVSWTSXVoc8kuwJOvQpOUFoqWRjVXPd5h3I9un9KhWV6r7qpvS3eROoU8RzzODywyeku+U2iztLrLI6ssY7y44bv/mFYcUrZGh7DUHBetWhscsZa4Bwc3Ne12kOB1gryzKfJuS75TPADJZXu7Zusxk7P/e3z64c4ctfv0f7/ACTaFfeW7PU+IiVNhaodmka8B7TUFWNlic9wYwZznahs3knYAozoJveXqSoyehss8TnuDGDOc7UPiTgBiu7ybuwQt8J7tL37TuGAGCgXLdjYG6e2ee7djuGA3K5itICt7W23PmepW3l0pLcjp9/YsV85gwHsCji2hZ461Tysyb8wYD2BC0YBRzb2r4N4NQG7iza1otzRRRI7WDtUpjqoA/UVHu7vnpPpapEmoqNdvfPSfS1ATEREAREQBERAEREB5p2R/v7PQR/PIrbJ8dqFVdkb7+z0EfzyK9ybjq0IC8jqAtU8xCsGQii4vLO8bRw4s9ndwQaxr5ZaAu7atGNqCBoFSabQttGk6st1Gm4rxoQc56F8LS4YqRFbRqJouAbZbQe6t9q/SWj+FPsdgfttU7/SPH8AKW7HC4y+5V+dU3/jFv6L+yzvC050rzX8WaNwbUU9ucfWvmGVc4208VkdHaHEROcXQ2h5JZ2xqYpHbCCTQnWCNqmy35Z2aBKJXHUyH+q8/pZU+tUNa1nGo44y/v8AwdHbXtKrRVVPCx04dHyZ0DLTRYnt8RaWyZrmuBDmuoQRgVyst4WiXuGNs7PClo+U/oaaD1u9SxDYRUOfJJK4aayEZtfyCjf2UujserNZnwXXUrrnb9tTeIfM+mnfgj6GSZD3S2U/4d/bOElQxpxa7b6leXXBFA0hpz3nu37SRsGA3KBO90go6aUjDhH09lVCfdjTqntDfyyuUynseMHvOWWRan/JN5bu68fT+zp+Mk6qpwrlyTrmdsttsb/1Qf4Xwbnm2W+1jzvBUjwD5kdbapvVPsdhwj1gveuP+x7R/mFp5w6Vg3Raf8wn9bj0p4F8zJbYo9ex1r3vWl8j8Vyr7otmy3SHzvI/hV9rdbYT21onB2HOY9p/aixdlLmbY7TpS0O8stvc11HaF0t3T5wC86yfvZ08R4SnCxPzHkCgdqIcBsqD7QV3txMOaKqHODhLDLCE1NbyLSTUo92989J9LVJk1FRrt756T6WrAzJiIiAIiIAiIgCIiA817I3/ADCP0EfzyLo8lzoaub7I5/x7PQR/PIrrJuagCA7BUGUFyukeJYs0uzQx7T2pcASQ5rsdJFDr0aRTTeRPqF9rOnUlCW9HU1VqMK0HCa4HEOuG1eIPPi66wLgtfiTz4uuu4RSvH1enb3IPlFtyff2OLZclr1cDUHWHGFwPqLlp5NWkVzYQ2uxromj9iu6ReK+qrTHb3PPJ7Xk+/scGcnLX4n3ousscnbX4n34usu9Re+YVunb3MvKbbr39jg+T1s8T78XWTk9a/EnnxdZd4iePrdO3uPKrfr39jg+T1r8R78XWTk9a/Ee/F1l3iJ4+t07e48qt+vf2OE5PWvxJ58XWTk9a/E+/F1l3aJ4+t07e48pt+vf2OE5P2vxPvRdZRryyWtkjM1sIrsL5I6D2OJXoiJ4+r07HnlNtnPHucRktkY6zspKQ+R7s+QtrmV0ANFdgAXY2aAMFFuRRJzc3lljCCgsI+X6io93d89J9LVIk1FRrt756T6WrEyJiIiAIiIAiIgCIiA8z7JopbWHYbPHT1PkW3J62aAp/ZTu4lkVoaP8AhkxSfldQtJ3VBH6guOuy2lhA2ID1KwWzQFZMmBXEXdeYoNKuYLw3oDoQVlU7LwGK2i370BZoq7j4xTj+9AWKKv4+MU4+MUBYIq/j4xTj4xQFgir+PjFOPjFAWCKv4+MVnj4xQE9FA4+MU49vQE9YJUHju9fD7YMUBLtEootN0uqJD/uH5Wqqt94gAmqtrnhLImZwo53buG0F2mh8woPUgJqIiAIiIAiIgCIiAjXhZGTRvjkGcyRpa4bjtGBGuu5eR5QXJLY5jHICWmpikHcyMx3HEbPNReyqJeN3xTxmOZgkYdh1g4gjSDvCA8ds1uczarOC/Kayri9exzICTZpWub4E1WuG4PAofWAqaTIy8Afu5O9r4SPmQEtl/jFfYygGKr+R14eTO58PWWeR94eTO58PWQFhyhGKzyhGKreR94eTO58PWTkdeHkzufD1kBZcoRinKEYqt5H3h5M7nw9ZOR94eTO58PWQFlyhGKcoRiq3kdeHkzufD1k5H3h5M7nwdZAWXKEYpyhGKreR14eTO58PWTkdeHkzufD1kBZ8oRis8oRiqvkfeHkzufD1lnkfeHkzufD1kBajKAeEvpt/jFVHI+8PJnc+HrJyQvDyZ/Ph6yAvBfgxWua/QNqrLPkTeDjQxCMYySR090k/sukuXsfRsIfaX8MRp4NtWx13nW79kBryZsT7W8TPBFnYatr354OoYtB1nbqxp261sYGgNaA1oADQNAAGoALYgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgP/2Q=="
                            width="30px" alt=""></h3>

                    <form method="POST" action="{{ route('update-user-profile', $user->id) }}">
                        @csrf
                        {{-- User Personal Info --}}
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label" for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control"
                                    placeholder="John" value="{{ $user->first_name }}" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control"
                                    placeholder="Doe" value="{{ $user->last_name }}" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="address">Address</label>
                                <textarea id="address" name="address" class="form-control" placeholder="123 Main St">{{ $user->address }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="john.doe" aria-label="john.doe" aria-describedby="emailSuffix"
                                        value="{{ $user->email }}" disabled />
                                    <span class="input-group-text" id="emailSuffix">@gmail.com</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone No</label>
                                <input type="text" id="phone_number" name="phone_number"
                                    class="form-control phone-mask" placeholder="123-456-7890" aria-label="123-456-7890"
                                    value="{{ $user->phone_number }}" />
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('user-dashboard') }}" class="btn btn-label-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
