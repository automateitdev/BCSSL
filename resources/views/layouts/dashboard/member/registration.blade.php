@extends('home')

@section('content')
    <div id="enrollment_auto">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="mb-25">
                        <a href="{{ route('register.index') }}">Enrollement</a>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="pills-reg-tab" name="nav_tab">
                                <h3>Personal Info</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nameinput" class="form-label">Name</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="text" class="form-control" id="nameinput" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="f_name" class="form-label">Father Name</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="text" class="form-control" id="f_name" name="f_name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <select class="form-select" name="gender" required>
                                                <option selected>Choose One</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Others</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="mstatus" class="form-label">Marital Status</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <select class="form-select" name="marital_status" required>
                                                <option selected>Choose One</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Divorced">Divorced</option>
                                                <option value="Cohabiting">Cohabiting</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nid" class="form-label">National ID</label>
                                            <input type="text" onkeypress="return /[0-9]/i.test(event.key)"
                                                maxlength="20" class="form-control" id="nid" name="nid">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mobile" class="form-label">Mobile No</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="text" onkeypress="return /[0-9]/i.test(event.key)"
                                                maxlength="11" class="form-control" id="mobile" name="mobile"
                                                required>
                                            <div id="mobile" class="form-text">Please, use valid number for
                                                sms.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="password" class="form-control" id="password" name="password"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dbirth" class="form-label">Date of Birth</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="date" class="form-control" id="dbirth" name="birth_date"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="m_name" class="form-label">Mother Name</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="text" class="form-control" id="m_name" name="m_name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="religion" class="form-label">Religion</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <select class="form-select" name="religion" required>
                                                <option selected>Choose One</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Hinduism">Hinduism</option>
                                                <option value="Buddhism">Buddhism</option>
                                                <option value="Christianity">Christianity</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="religion" class="form-label">Blood</label>
                                            <select class="form-select" name="blood_grp">
                                                <option selected>Choose One</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nationality" class="form-label">Nationality</label>
                                            <input type="text" class="form-control" id="nationality"
                                                name="nationality">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                            <div id="uu" class="form-text">Please, use valid email.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="file" class="form-control" id="image" name="image"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <h4>Present Address</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="present_address" class="form-label">Address</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="text" class="form-control" id="present_address"
                                                name="present_address" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="present_thana" class="form-label">Thana</label>
                                            <input type="text" class="form-control" id="present_thana"
                                                name="present_thana">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="present_district" class="form-label">District</label>
                                            <input type="text" class="form-control" id="present_district"
                                                name="present_district">
                                        </div>
                                        <div class="mb-3">
                                            <label for="present_division" class="form-label">Division</label>
                                            <input type="text" class="form-control" id="present_division"
                                                name="present_division">
                                        </div>
                                    </div>
                                </div>
                                <h4>Permanent Address</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="permanent_address" class="form-label">Address</label><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <input type="text" class="form-control" id="permanent_address"
                                                name="permanent_address" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="permanent_thana" class="form-label">Thana</label>
                                            <input type="text" class="form-control" id="permanent_thana"
                                                name="permanent_thana">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="permanent_district" class="form-label">District</label>
                                            <input type="text" class="form-control" id="permanent_district"
                                                name="permanent_district">
                                        </div>
                                        <div class="mb-3">
                                            <label for="permanent_division" class="form-label">Division</label>
                                            <input type="text" class="form-control" id="permanent_division"
                                                name="permanent_division">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
