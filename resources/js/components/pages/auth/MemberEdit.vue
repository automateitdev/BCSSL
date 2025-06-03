<template>
    <div>
        <!-- <div
            v-if="account_waiting_apporve"
            class="alert alert-success alert-dismissible fade"
            role="alert"
            :class="{ show: account_waiting_apporve }"
        >
            Successfull, waiting for approved
            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div> -->
        <vue-element-loading :active="isLoading" is-full-screen />
        <form action="">
            <form-wizard
                title=""
                subtitle=""
                shape="tab"
                color="#38a4f8"
                step-size="xs"
                errorColor="#e91313"
                :nextButtonText="`Next`"
                :backButtonText="`Back`"
                :finishButtonText="`Finish`"
            >
                <wizard-step
                    slot-scope="props"
                    slot="step"
                    :tab="props.tab"
                    :transition="props.transition"
                    :index="props.index"
                >
                </wizard-step>
                <tab-content
                    title="Applicant’s Information"
                    :lazy="true"
                    :before-change="additionalInfoTabChange"
                >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label
                                                    for="name"
                                                    class="form-label"
                                                    >Name <span>*</span> </label
                                                ><svg
                                                    width="16"
                                                    height="16"
                                                ></svg>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    v-model.trim="
                                                        $v.form.applicant_info
                                                            .name.$model
                                                    "
                                                />
                                            </div>
                                            <div
                                                class="error"
                                                style="color: red"
                                                v-if="
                                                    !$v.form.applicant_info.name
                                                        .required &&
                                                    additional_info_error
                                                "
                                            >
                                                Field is required
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label
                                                    for="father_name"
                                                    class="form-label"
                                                    >Father's Name
                                                    <span>*</span></label
                                                ><svg
                                                    width="16"
                                                    height="16"
                                                ></svg>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="father_name"
                                                    name="father_name"
                                                    v-model.trim="
                                                        $v.form.applicant_info
                                                            .father_name.$model
                                                    "
                                                />
                                                <div
                                                    class="error"
                                                    style="color: red"
                                                    v-if="
                                                        !$v.form.applicant_info
                                                            .father_name
                                                            .required &&
                                                        additional_info_error
                                                    "
                                                >
                                                    Field is required
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label
                                                    for="mother_name"
                                                    class="form-label"
                                                    >Mother's Name
                                                    <span>*</span></label
                                                ><svg
                                                    width="16"
                                                    height="16"
                                                ></svg>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="mother_name"
                                                    name="mother_name"
                                                    v-model.trim="
                                                        $v.form.applicant_info
                                                            .mother_name.$model
                                                    "
                                                />
                                                <div
                                                    class="error"
                                                    style="color: red"
                                                    v-if="
                                                        !$v.form.applicant_info
                                                            .mother_name
                                                            .required &&
                                                        additional_info_error
                                                    "
                                                >
                                                    Field is required
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label
                                                    for="spouse_name"
                                                    class="form-label"
                                                    >Name of Spouse</label
                                                ><svg
                                                    width="16"
                                                    height="16"
                                                ></svg>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="spouse_name"
                                                    name="spouse_name"
                                                    v-model.trim="
                                                        $v.form.applicant_info
                                                            .spouse_name.$model
                                                    "
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="user_img"
                                        >Applicant’s Image <span>*</span></label
                                    >
                                    <input
                                        type="file"
                                        @change="userPPImageChange($event)"
                                    />
                                    <img
                                        :src="userPPImage()"
                                        alt=""
                                        class="img-fluid"
                                        style="height: 250px; width: 250px"
                                        @error="
                                            event.target.src =
                                                '/assets/images/dummy_pp_image.jpg'
                                        "
                                    />
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="user_image_error"
                                    >
                                        Field is required
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="current_occupation"
                                    class="form-label"
                                    >Current Occupation <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="text"
                                    id="current_occupation"
                                    name="current_occupation"
                                    v-model.trim="
                                        $v.form.applicant_info
                                            .current_occupation.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .current_occupation.required &&
                                        additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="current_designation"
                                    class="form-label"
                                    >Current Designation </label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="text"
                                    id="current_designation"
                                    name="current_designation"
                                    v-model.trim="
                                        $v.form.applicant_info
                                            .current_designation.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .current_designation.required &&
                                        additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .current_designation.numeric &&
                                        additional_info_error
                                    "
                                >
                                    Field is numeric
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="current_occupation_joining"
                                    class="form-label"
                                    >Joining Date </label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="date"
                                    id="current_occupation_joining"
                                    name="current_occupation_joining"
                                    v-model.trim="
                                        $v.form.applicant_info
                                            .current_occupation_joining.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .current_occupation_joining
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .current_occupation_joining
                                            .numeric && additional_info_error
                                    "
                                >
                                    Field is numeric
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="current_office_address"
                                    class="form-label"
                                    >Current Office Address </label
                                ><svg width="16" height="16"></svg>

                                <textarea
                                    class="form-control"
                                    id="current_office_address"
                                    name="current_office_address"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.applicant_info
                                            .current_office_address.$model
                                    "
                                ></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="birth_date" class="form-label"
                                    >Date of Birth <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="date"
                                    id="birth_date"
                                    name="birth_date"
                                    v-model.trim="
                                        $v.form.applicant_info.birth_date.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.birth_date
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label"
                                    >Gender <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <select
                                    class="form-select"
                                    name="gender"
                                    v-model.trim="
                                        $v.form.applicant_info.gender.$model
                                    "
                                >
                                    <option selected="selected" disabled>
                                        Choose One
                                    </option>
                                    <option
                                        v-for="(gender, key) in userGender"
                                        :key="key"
                                        :value="key"
                                    >
                                        {{ gender }}
                                    </option>
                                </select>
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.gender
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="blood_group" class="form-label"
                                    >Blood Group <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <select
                                    class="form-select"
                                    name="blood_group"
                                    v-model.trim="
                                        $v.form.applicant_info.blood_group
                                            .$model
                                    "
                                >
                                    <option selected="selected" disabled>
                                        Choose One
                                    </option>
                                    <option
                                        v-for="(
                                            blood_group, key
                                        ) in userBloodGroup"
                                        :key="key"
                                        :value="key"
                                    >
                                        {{ blood_group }}
                                    </option>
                                </select>
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.blood_group
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mobile" class="form-label"
                                    >Mobile Number <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <VuePhoneNumberInput
                                    :default-country-code="
                                        form.applicant_info.country_code
                                    "
                                    v-model="
                                        $v.form.applicant_info.mobile.$model
                                    "
                                    @update="applicent_mobile_number"
                                />

                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.mobile
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label"
                                    >Email Address <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="email"
                                    id="email"
                                    name="email"
                                    v-model.trim="
                                        $v.form.applicant_info.email.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.email
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.email.email &&
                                        additional_info_error
                                    "
                                >
                                    Field is Email
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label"
                                    >Password </label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="password"
                                    id="password"
                                    name="password"
                                    v-model.trim="
                                        $v.form.applicant_info.password.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.password
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.password
                                            .minLength && additional_info_error
                                    "
                                >
                                    Password must have at least
                                    {{
                                        $v.form.applicant_info.password.$params
                                            .minLength.min
                                    }}
                                    letters.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nid" class="form-label"
                                    >National ID Number <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="text"
                                    id="nid"
                                    name="nid"
                                    v-model.trim="
                                        $v.form.applicant_info.nid.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.nid.required &&
                                        additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="current_occupation"
                                    class="form-label"
                                    >Current Occupation <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="current_occupation"
                                    name="current_occupation"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.applicant_info
                                            .current_occupation.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .current_occupation.required &&
                                        additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="current_designation"
                                    class="form-label"
                                    >Current Designation <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="current_designation"
                                    name="current_designation"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.applicant_info
                                            .current_designation.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .current_designation.required &&
                                        additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="current_occupation_joining"
                                    class="form-label"
                                    >Joining Date <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="current_occupation_joining"
                                    name="current_occupation_joining"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.applicant_info
                                            .current_occupation_joining.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .current_occupation_joining
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="current_office_address"
                                    class="form-label"
                                    >Current Office Address </label
                                ><svg width="16" height="16"></svg>

                                <textarea
                                    class="form-control"
                                    id="current_office_address"
                                    name="current_office_address"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.applicant_info
                                            .current_office_address.$model
                                    "
                                ></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="present_address" class="form-label"
                                    >Present Address</label
                                ><svg width="16" height="16"></svg>

                                <textarea
                                    class="form-control"
                                    id="present_address"
                                    name="present_address"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.applicant_info.present_address
                                            .$model
                                    "
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="permanent_address"
                                    class="form-label"
                                    >Permanent Address </label
                                ><svg width="16" height="16"></svg>

                                <textarea
                                    class="form-control"
                                    id="permanent_address"
                                    name="permanent_address"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.applicant_info.permanent_address
                                            .$model
                                    "
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="emergency_contact"
                                    class="form-label"
                                    >Emergency Contact </label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="text"
                                    id="emergency_contact"
                                    name="emergency_contact"
                                    v-model.trim="
                                        $v.form.applicant_info.emergency_contact
                                            .$model
                                    "
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="signature" class="form-label"
                                    >Signature <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="signature"
                                    @change="userSIGImageChange($event)"
                                />
                                <img
                                    :src="userSIGImage()"
                                    alt="Applicant’s Signature "
                                    class="signature_img"
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="user_signature_error"
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="signature" class="form-label"
                                    >NID Front Side <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="signature"
                                    @change="
                                        userNIDImageChange($event, 'front')
                                    "
                                />
                                <img
                                    :src="userNIDImage('front')"
                                    alt="Nid Front
                                side"
                                    class="w-100 border-1"
                                    style="height: 220px"
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="user_nid_f_error"
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="signature" class="form-label"
                                    >NID Back Side <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="signature"
                                    @change="userNIDImageChange($event, 'back')"
                                />
                                <img
                                    :src="userNIDImage('back')"
                                    alt="Nid back side "
                                    class="w-100 border-1"
                                    style="height: 220px"
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="user_nid_bc_error"
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nid" class="form-label"
                                    >Reference Name <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="text"
                                    id="nid"
                                    name="nid"
                                    v-model.trim="
                                        $v.form.applicant_info.ref_name.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.ref_name
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nid" class="form-label"
                                    >Reference Mobile <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="text"
                                    id="nid"
                                    name="nid"
                                    v-model.trim="
                                        $v.form.applicant_info.ref_mobile.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.ref_mobile
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nid" class="form-label"
                                    >Reference Member Id Number
                                    <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="text"
                                    id="nid"
                                    name="nid"
                                    v-model.trim="
                                        $v.form.applicant_info.ref_memeber_id_no
                                            .$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info
                                            .ref_memeber_id_no.required &&
                                        additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                    </div>
                </tab-content>
                <tab-content
                    title="Nominee’s Information"
                    :lazy="true"
                    :before-change="nomineeInfoTabChange"
                >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label
                                                    for="nominee_name"
                                                    class="form-label"
                                                    >Name of Nominee
                                                    <span>*</span></label
                                                ><svg
                                                    width="16"
                                                    height="16"
                                                ></svg>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="nominee_name"
                                                    name="name"
                                                    v-model.trim="
                                                        $v.form.nominee_info
                                                            .name.$model
                                                    "
                                                />
                                                <div
                                                    class="error"
                                                    style="color: red"
                                                    v-if="
                                                        !$v.form.nominee_info
                                                            .name.required &&
                                                        nominee_info_error
                                                    "
                                                >
                                                    Field is required
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label
                                                    for="nominee_father_name"
                                                    class="form-label"
                                                    >Father's Name
                                                    <span>*</span></label
                                                ><svg
                                                    width="16"
                                                    height="16"
                                                ></svg>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="nominee_father_name"
                                                    name="father_name"
                                                    v-model.trim="
                                                        $v.form.nominee_info
                                                            .father_name.$model
                                                    "
                                                />
                                                <div
                                                    class="error"
                                                    style="color: red"
                                                    v-if="
                                                        !$v.form.nominee_info
                                                            .father_name
                                                            .required &&
                                                        nominee_info_error
                                                    "
                                                >
                                                    Field is required
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label
                                                    for="nominee_mother_name"
                                                    class="form-label"
                                                    >Mother's Name
                                                    <span>*</span></label
                                                ><svg
                                                    width="16"
                                                    height="16"
                                                ></svg>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="nominee_mother_name"
                                                    name="mother_name"
                                                    v-model.trim="
                                                        $v.form.nominee_info
                                                            .mother_name.$model
                                                    "
                                                />
                                                <div
                                                    class="error"
                                                    style="color: red"
                                                    v-if="
                                                        !$v.form.nominee_info
                                                            .mother_name
                                                            .required &&
                                                        nominee_info_error
                                                    "
                                                >
                                                    Field is required
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="user_img"
                                        >Applicant’s Nominee Image
                                        <span>*</span></label
                                    >
                                    <input
                                        type="file"
                                        @change="
                                            userNomineePPImageChange($event)
                                        "
                                    />
                                    <img
                                        :src="userNomineePPImage()"
                                        alt=""
                                        class="img-fluid"
                                        style="height: 250px; width: 250px"
                                        @error="
                                            event.target.src =
                                                '/assets/images/dummy_pp_image.jpg'
                                        "
                                    />
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="nominee_image_error"
                                    >
                                        Field is required
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="nominee_birth_date"
                                    class="form-label"
                                    >Date of Birth </label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="date"
                                    id="nominee_birth_date"
                                    name="birth_date"
                                    v-model.trim="
                                        $v.form.nominee_info.birth_date.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.nominee_info.birth_date
                                            .required && nominee_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nominee_gender" class="form-label"
                                    >Gender </label
                                ><svg width="16" height="16"></svg>

                                <select
                                    class="form-select"
                                    id="nominee_gender"
                                    name="gender"
                                    v-model.trim="
                                        $v.form.nominee_info.gender.$model
                                    "
                                >
                                    <option selected="" disabled>
                                        Choose One
                                    </option>
                                    <option
                                        v-for="(gender, key) in userGender"
                                        :key="key"
                                        :value="key"
                                    >
                                        {{ gender }}
                                    </option>
                                </select>
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.nominee_info.gender.required &&
                                        nominee_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nominee_mobile" class="form-label"
                                    >Mobile Number </label
                                ><svg width="16" height="16"></svg>
                                <VuePhoneNumberInput
                                    :default-country-code="
                                        form.nominee_info.country_code
                                    "
                                    v-model.trim="
                                        $v.form.nominee_info.mobile.$model
                                    "
                                    @update="nominee_mobile_number"
                                />

                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.nominee_info.mobile.required &&
                                        nominee_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nominee_email" class="form-label"
                                    >Email Address </label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="email"
                                    id="nominee_email"
                                    name="nominee_email"
                                    v-model.trim="
                                        $v.form.nominee_info.email.$model
                                    "
                                />

                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.nominee_info.email.email &&
                                        nominee_info_error
                                    "
                                >
                                    Field is Email
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nominee_nid" class="form-label"
                                    >National ID Number </label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="text"
                                    id="nominee_nid"
                                    name="nid"
                                    v-model.trim="
                                        $v.form.nominee_info.nid.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.nominee_info.nid.required &&
                                        nominee_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="relation_with_user"
                                    class="form-label"
                                    >Relationship with Applicant</label
                                ><svg width="16" height="16"></svg>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="relation_with_user"
                                    name="relation_with_user"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.nominee_info.relation_with_user
                                            .$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.nominee_info.relation_with_user
                                            .required && nominee_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="nominee_professional_details"
                                    class="form-label"
                                    >Professional details </label
                                ><svg width="16" height="16"></svg>

                                <textarea
                                    class="form-control"
                                    id="nominee_professional_details"
                                    name="professional_details"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.nominee_info
                                            .professional_details.$model
                                    "
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="nominee_permanent_address"
                                    class="form-label"
                                    >Permanent Address </label
                                ><svg width="16" height="16"></svg>

                                <textarea
                                    class="form-control"
                                    id="nominee_permanent_address"
                                    name="permanent_address"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.nominee_info.permanent_address
                                            .$model
                                    "
                                ></textarea>
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.nominee_info.permanent_address
                                            .required && nominee_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="signature" class="form-label"
                                    >NID Front Side <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="signature"
                                    @change="
                                        nomineeNIDImageChange($event, 'fontend')
                                    "
                                />
                                <img
                                    :src="nomineeNIDImage('fontend')"
                                    alt="Nid Front
                                side"
                                    class="w-100 border-1"
                                    style="height: 220px"
                                />

                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="nominee_nid_f_error"
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="signature" class="form-label"
                                    >NID Back Side <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="signature"
                                    @change="
                                        nomineeNIDImageChange($event, 'back')
                                    "
                                />
                                <img
                                    :src="nomineeNIDImage('backend')"
                                    alt="Nid back side "
                                    class="w-100 border-1"
                                    style="height: 220px"
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="nominee_nid_bc_error"
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                    </div>
                </tab-content>
                <tab-content
                    title="Member Choice"
                    :lazy="true"
                    :before-change="finalTabChange"
                >
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" width="19%"></th>
                                        <th scope="col" width="27%">
                                            Project-1 <br />
                                            Areas in Dhaka City Corporation
                                        </th>
                                        <th scope="col" width="27%">
                                            Project-2
                                            <br />
                                            Areas close to Dhaka City
                                            Corporation
                                        </th>
                                        <th scope="col" width="27%">
                                            Project-3 <br />Other District
                                            Except Dhaka
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Prefered Area:</th>
                                        <td>
                                            <multiselect
                                                v-model="
                                                    form.member_choice.project_1
                                                        .prefered_area
                                                "
                                                tag-placeholder="Add this as new tag"
                                                placeholder="Search Prefered Area"
                                                label="label"
                                                track-by="value"
                                                :options="
                                                    areaOfDhakaCityPA.map(
                                                        (data) => {
                                                            return {
                                                                label: data.value,
                                                                value: data.value,
                                                            };
                                                        }
                                                    )
                                                "
                                                :multiple="true"
                                                :taggable="true"
                                            ></multiselect>

                                            <!-- <select name="" id="" multiple>
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in areaOfDhakaCityPA"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select> -->
                                        </td>
                                        <td>
                                            <multiselect
                                                v-model="
                                                    form.member_choice.project_2
                                                        .prefered_area
                                                "
                                                tag-placeholder="Add this as new tag"
                                                placeholder="Search Prefered Area"
                                                label="label"
                                                track-by="value"
                                                :options="
                                                    areaCloseOfDhakaCityPA.map(
                                                        (data) => {
                                                            return {
                                                                label: data.value,
                                                                value: data.value,
                                                            };
                                                        }
                                                    )
                                                "
                                                :multiple="true"
                                                :taggable="true"
                                            ></multiselect>
                                        </td>
                                        <td>
                                            <multiselect
                                                v-model="
                                                    form.member_choice.project_3
                                                        .prefered_area
                                                "
                                                tag-placeholder="Add this as new tag"
                                                placeholder="Search Prefered Area"
                                                label="label"
                                                track-by="value"
                                                :options="
                                                    allDisticts.map((data) => {
                                                        return {
                                                            label: data.name,
                                                            value: data.name,
                                                        };
                                                    })
                                                "
                                                :multiple="true"
                                                :taggable="true"
                                            ></multiselect>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row">
                                            Capacity Range (Tk.)
                                        </td>
                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_1
                                                        .capacity_range
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in capacity_ranges"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_2
                                                        .capacity_range
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in capacity_ranges"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_3
                                                        .capacity_range
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in capacity_ranges"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row">
                                            Prefered Flat Size(Net)
                                        </td>
                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_1
                                                        .flat_size
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in flat_sizes"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_2
                                                        .flat_size
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in flat_sizes"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_3
                                                        .flat_size
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in flat_sizes"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row">Expected Bank Loan</td>
                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_1
                                                        .exp_bank_loan
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in exp_bank_loans"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_2
                                                        .exp_bank_loan
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in exp_bank_loans"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_3
                                                        .exp_bank_loan
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in exp_bank_loans"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row">
                                            Number of Flat Share:
                                        </td>
                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_1
                                                        .num_flat_shares
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in num_flat_shares"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_2
                                                        .num_flat_shares
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in num_flat_shares"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_3
                                                        .num_flat_shares
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in num_flat_shares"
                                                    :key="key"
                                                    :value="value.value"
                                                >
                                                    {{ value.value }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row">
                                            Project introducer Name
                                        </td>
                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_1
                                                        .p_introducer_name
                                                "
                                                @change="
                                                    changeIngroducerName(
                                                        'introducer_1'
                                                    )
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in allMembersData"
                                                    :key="key"
                                                    :value="value.name"
                                                >
                                                    {{ value.name }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_2
                                                        .p_introducer_name
                                                "
                                                @change="
                                                    changeIngroducerName(
                                                        'introducer_2'
                                                    )
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in allMembersData"
                                                    :key="key"
                                                    :value="value.name"
                                                >
                                                    {{ value.name }}
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select
                                                class="form-control"
                                                name=""
                                                id=""
                                                v-model="
                                                    form.member_choice.project_3
                                                        .p_introducer_name
                                                "
                                                @change="
                                                    changeIngroducerName(
                                                        'introducer_3'
                                                    )
                                                "
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    Select One
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key
                                                    ) in allMembersData"
                                                    :key="key"
                                                    :value="value.name"
                                                >
                                                    {{ value.name }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row">
                                            Project introducer Member Id
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="
                                                    form.member_choice.project_1
                                                        .p_introducer_member_num
                                                "
                                                readonly
                                            />
                                        </td>

                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="
                                                    form.member_choice.project_2
                                                        .p_introducer_member_num
                                                "
                                                readonly
                                            />
                                        </td>

                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="
                                                    form.member_choice.project_3
                                                        .p_introducer_member_num
                                                "
                                                readonly
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </tab-content>
            </form-wizard>
        </form>
    </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";

//validaiton
import { required, numeric, minLength, email } from "vuelidate/lib/validators";

//
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

//vue element loader
import VueElementLoading from "vue-element-loading";

export default {
    name: "MemberEdit",
    props: ["userGender", "userBloodGroup", "member"],
    data() {
        return {
            form: {
                applicant_info: {
                    name: "",
                    father_name: "",
                    mother_name: "",
                    spouse_name: "",
                    image: "",
                    bc_image: "",
                    birth_date: "",
                    gender: "",
                    blood_group: "",
                    mobile: "",
                    email: "",
                    password: "",
                    nid: "",
                    current_occupation: "",
                    current_designation: "",
                    current_occupation_joining: "",
                    current_office_address: "",
                    present_address: "",
                    permanent_address: "",
                    emergency_contact: "",
                    signature: "",
                    bc_signature: "",
                    nid_front: "",
                    bc_nid_front: "",
                    nid_back: "",
                    bc_nid_back: "",
                    formattedNumber: "",
                    country_code: "BD",
                    ref_name: "",
                    ref_mobile: "",
                    ref_memeber_id_no: "",
                },
                nominee_info: {
                    name: "",
                    father_name: "",
                    mother_name: "",
                    image: "",
                    bc_image: "",
                    birth_date: "",
                    gender: "",
                    mobile: "",
                    email: "",
                    relation_with_user: "",
                    nid: "",
                    professional_details: "",
                    permanent_address: "",
                    nid_front: "",
                    bc_nid_front: "",
                    nid_back: "",
                    bc_nid_back: "",
                    formattedNumber: "",
                    country_code: "BD",
                },
                member_choice: {
                    project_1: {
                        project_type: "area_of_dhaka_city",
                        prefered_area: [],
                        capacity_range: "",
                        flat_size: "",
                        exp_bank_loan: "",
                        num_flat_shares: "",
                        p_introducer_name: "",
                        p_introducer_member_num: "",
                    },
                    project_2: {
                        project_type: "area_close_to_dhaka_city",
                        prefered_area: [],
                        capacity_range: "",
                        flat_size: "",
                        exp_bank_loan: "",
                        num_flat_shares: "",
                        p_introducer_name: "",
                        p_introducer_member_num: "",
                    },
                    project_3: {
                        project_type: "other_distict",
                        prefered_area: [],
                        capacity_range: "",
                        flat_size: "",
                        exp_bank_loan: "",
                        num_flat_shares: "",
                        p_introducer_name: "",
                        p_introducer_member_num: "",
                    },
                },
            },
            user_image_error: false,
            user_signature_error: false,
            user_nid_f_error: false,
            user_nid_bc_error: false,
            additional_info_error: false,

            nominee_info_error: false,
            nominee_image_error: false,
            nominee_nid_f_error: false,
            nominee_nid_bc_error: false,

            final_change_error: false,

            account_waiting_apporve: false,
            user_join_cader_error: false,
            user_supervis_auth_error: false,

            isLoading: false,
            allDisticts: [],
            areaOfDhakaCityPA: [
                {
                    value: "Afteb Nagar",
                },
                {
                    value: "Mohammadpur",
                },
                {
                    value: "Uttara",
                },
                {
                    value: "Basundhora/Purbachal",
                },

                {
                    value: "Other",
                },
            ],
            areaCloseOfDhakaCityPA: [
                {
                    value: "Amin Bazar",
                },
                {
                    value: "Ghatar Chor",
                },
                {
                    value: "Birulia",
                },
                {
                    value: "Narayangonj",
                },
                {
                    value: "Other",
                },
            ],
            capacity_ranges: [
                {
                    value: "Tk. 5-15 Lac",
                },
                {
                    value: "Tk. 15-25 Lac",
                },
                {
                    value: "Tk. 25-35 Lac",
                },
                {
                    value: "Above Tk. 35 Lac",
                },
            ],
            flat_sizes: [
                {
                    value: "1,200 sft",
                },
                {
                    value: "1,500 sft",
                },
                {
                    value: "1,800 sft",
                },
                {
                    value: "2,000 sft",
                },
            ],
            exp_bank_loans: [
                {
                    value: "No",
                },
                {
                    value: "25%",
                },
                {
                    value: "50%",
                },
                {
                    value: "75%",
                },
            ],
            num_flat_shares: [
                {
                    value: "1",
                },
                {
                    value: "2",
                },
                {
                    value: "3",
                },
                {
                    value: "4",
                },
            ],
            allMembersData: [],
        };
    },
    components: {
        FormWizard,
        TabContent,
        VuePhoneNumberInput,
        VueElementLoading,
    },
    validations: {
        form: {
            applicant_info: {
                name: {
                    required,
                },
                father_name: {
                    required,
                },
                mother_name: {
                    required,
                    // minLength: minLength(3),
                },
                spouse_name: {},
                image: {},

                birth_date: {
                    required,
                },

                gender: {
                    required,
                },

                blood_group: {
                    required,
                },

                mobile: {
                    required,
                },
                email: {
                    required,
                    email,
                },
                password: {
                    required: false,
                    minLength: minLength(6),
                },
                nid: {
                    required,
                },

                current_occupation: {
                    required: true,
                },

                current_designation: {
                    required: true,
                },

                current_occupation_joining: {
                    required: true,
                },

                current_office_address: {},

                present_address: {},
                permanent_address: {},
                emergency_contact: {},
                ref_name: {
                    required,
                },
                ref_mobile: {
                    required,
                },
                ref_memeber_id_no: {
                    required,
                },
            },
            nominee_info: {
                name: {
                    required,
                },
                father_name: {
                    required,
                },
                mother_name: {
                    required,
                    // minLength: minLength(3),
                },
                image: {
                    required: false,
                },
                birth_date: {
                    required,
                },
                gender: {
                    required,
                },
                mobile: {
                    required,
                },
                email: {
                    email,
                },

                relation_with_user: {
                    required,
                },
                permanent_address: {
                    required,
                },
                professional_details: {},
                nid: {
                    required,
                },
                nid_front: {},
                nid_back: {},
            },
            member_choice: {},
        },
    },
    created() {
        this.initialApproveCheck();
        this.initialDataSet();
        this.fetchData();
    },
    methods: {
        changeIngroducerName(type) {
            let self = this;
            if (type == "introducer_1") {
                let find = self.allMembersData.find(
                    (member) =>
                        member.name ==
                        self.form.member_choice.project_1.p_introducer_name
                );
                if (find) {
                    // self.form.member_choice.project_1.p_introducer_name =
                    //     find.name;
                    self.form.member_choice.project_1.p_introducer_member_num =
                        find.associators_info != ""
                            ? find.associators_info.membershp_number
                            : "";
                }
            } else if (type == "introducer_2") {
                let find = self.allMembersData.find(
                    (member) =>
                        member.name ==
                        self.form.member_choice.project_2.p_introducer_name
                );
                if (find) {
                    // self.form.member_choice.project_2.p_introducer_name =
                    //     find.name;
                    self.form.member_choice.project_2.p_introducer_member_num =
                        find.associators_info != ""
                            ? find.associators_info.membershp_number
                            : "";
                }
            } else if (type == "introducer_3") {
                let find = self.allMembersData.find(
                    (member) =>
                        member.name ==
                        self.form.member_choice.project_3.p_introducer_name
                );
                if (find) {
                    // self.form.member_choice.project_3.p_introducer_name =
                    //     find.name;
                    self.form.member_choice.project_3.p_introducer_member_num =
                        find.associators_info != ""
                            ? find.associators_info.membershp_number
                            : "";
                }
            }
        },
        fetchData() {
            let self = this;
            axios
                .get("/api/fetch-all-disticts")
                .then((response) => {
                    self.allDisticts = [...response.data];
                    self.allDisticts.unshift({
                        name: "Other",
                        id: 0,
                    });
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            //fetch members

            axios
                .get(
                    `/api/get-members?select[]=id&select[]=status&select[]=name&with[]=associatorsInfo:member_id,membershp_number&where[0][]=status&where[0][]==&where[0][]=active`
                )
                .then((response) => {
                    self.allMembersData = [...response.data];

                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
        },
        applicent_mobile_number(event) {
            this.form.applicant_info.formattedNumber = event.formattedNumber;
            this.form.applicant_info.country_code = event.countryCode;
        },
        nominee_mobile_number(event) {
            this.form.nominee_info.country_code = event.countryCode;
            this.form.nominee_info.formattedNumber = event.formattedNumber;
        },
        proofSupervisAuthorChange(event) {
            // console.log(type);
            let self = this;
            let file = event.target.files[0];
            const reader = new FileReader();
            self.user_supervis_auth_error = false;
            reader.onload = (event) => {
                self.form.applicant_info.proof_signed_by_sup_author =
                    event.target.result;
            };

            reader.readAsDataURL(file);
        },
        joiningCadreFileChange(event) {
            // console.log(type);
            let self = this;
            let file = event.target.files[0];
            const reader = new FileReader();
            self.user_join_cader_error = false;
            reader.onload = (event) => {
                self.form.applicant_info.proof_joining_cadre =
                    event.target.result;
                self.form.applicant_info.bc_proof_joining_cadre =
                    event.target.result;
            };

            reader.readAsDataURL(file);
        },
        nomineeNIDImage(type) {
            if (type == "fontend") {
                if (this.form.nominee_info.bc_nid_front != "") {
                    return this.form.nominee_info.bc_nid_front;
                }
                return "/assets/images/nid_front.jpeg";
            } else {
                if (this.form.nominee_info.bc_nid_back != "") {
                    return this.form.nominee_info.bc_nid_back;
                }
                return "/assets/images/nid_back.png";
            }
        },
        nomineeNIDImageChange(event, type) {
            console.log(type);
            let self = this;
            let file = event.target.files[0];
            const reader = new FileReader();
            if (type == "fontend") {
                self.nominee_nid_f_error = false;
                reader.onload = (event) => {
                    self.form.nominee_info.nid_front = event.target.result;
                    self.form.nominee_info.bc_nid_front = event.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                self.nominee_nid_bc_error = false;
                reader.onload = (event) => {
                    self.form.nominee_info.nid_back = event.target.result;
                    self.form.nominee_info.bc_nid_back = event.target.result;
                };

                reader.readAsDataURL(file);
            }
        },
        userNIDImage(type) {
            if (type == "front") {
                if (this.form.applicant_info.bc_nid_front != "") {
                    return this.form.applicant_info.bc_nid_front;
                }
                return "/assets/images/nid_front.jpeg";
            } else {
                if (this.form.applicant_info.bc_nid_back != "") {
                    return this.form.applicant_info.bc_nid_back;
                }
                return "/assets/images/nid_back.png";
            }
        },
        userNIDImageChange(event, type) {
            let file = event.target.files[0];
            const reader = new FileReader();
            if (type == "front") {
                reader.onload = (event) => {
                    this.form.applicant_info.nid_front = event.target.result;
                    this.form.applicant_info.bc_nid_front = event.target.result;
                };
                this.user_nid_f_error = false;
            } else {
                reader.onload = (event) => {
                    this.form.applicant_info.nid_back = event.target.result;
                    this.form.applicant_info.bc_nid_back = event.target.result;
                };
                this.user_nid_bc_error = false;
            }

            reader.readAsDataURL(file);
        },
        userSIGImage() {
            if (this.form.applicant_info.bc_signature != "") {
                return this.form.applicant_info.bc_signature;
            }
            return "/assets/images/dummy_sig.png";
        },
        userSIGImageChange(event) {
            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.applicant_info.signature = event.target.result;
                this.form.applicant_info.bc_signature = event.target.result;
            };
            this.user_signature_error = false;
            reader.readAsDataURL(file);
        },
        userPPImage() {
            if (this.form.applicant_info.bc_image != "") {
                return this.form.applicant_info.bc_image;
            }

            return "/assets/images/dummy_pp_image.jpg";
        },
        userNomineePPImage() {
            if (this.form.nominee_info.bc_image != "") {
                return this.form.nominee_info.bc_image;
            }
            return "/assets/images/dummy_pp_image.jpg";
        },
        userPPImageChange(event) {
            // console.log(event);

            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.applicant_info.image = event.target.result;
                this.form.applicant_info.bc_image = event.target.result;
            };
            this.user_image_error = false;
            reader.readAsDataURL(file);
        },
        userNomineePPImageChange(event) {
            // console.log(event);

            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.nominee_info.image = event.target.result;
                this.form.nominee_info.bc_image = event.target.result;
            };
            this.nominee_image_error = false;
            reader.readAsDataURL(file);
        },

        firstChangeHandler() {
            return true;
        },

        async nomineeInfoTabChange() {
            this.$v.$touch();

            if (
                this.$v.form.nominee_info.name.$invalid ||
                this.$v.form.nominee_info.father_name.$invalid ||
                this.$v.form.nominee_info.mother_name.$invalid ||
                this.$v.form.nominee_info.birth_date.$invalid ||
                this.$v.form.nominee_info.gender.$invalid ||
                this.$v.form.nominee_info.mobile.$invalid ||
                this.$v.form.nominee_info.email.$invalid ||
                this.$v.form.nominee_info.relation_with_user.$invalid ||
                this.$v.form.nominee_info.permanent_address.$invalid ||
                this.$v.form.nominee_info.nid.$invalid
            ) {
                this.nominee_info_error = true;
                return false;
            }
            this.nominee_info_error = false;
            return true;
        },
        async additionalInfoTabChange() {
            this.$v.$touch();
            if (
                this.$v.form.applicant_info.name.$invalid ||
                this.$v.form.applicant_info.father_name.$invalid ||
                this.$v.form.applicant_info.mother_name.$invalid ||
                this.$v.form.applicant_info.current_occupation.$invalid ||
                this.$v.form.applicant_info.current_designation.$invalid ||
                this.$v.form.applicant_info.current_occupation_joining
                    .$invalid ||
                this.$v.form.applicant_info.birth_date.$invalid ||
                this.$v.form.applicant_info.gender.$invalid ||
                this.$v.form.applicant_info.blood_group.$invalid ||
                this.$v.form.applicant_info.mobile.$invalid ||
                this.$v.form.applicant_info.email.$invalid ||
                this.$v.form.applicant_info.password.$invalid
            ) {
                this.additional_info_error = true;
                return false;
            }
            this.additional_info_error = false;
            return true;
        },
        async finalTabChange() {
            this.final_change_error = false;
            this.memberProfileUpdate();
            return true;
        },

        memberProfileUpdate() {
            // this.isLoading = true;
            axios
                .put(
                    `/admin/member-management/report/member-profile-update/${this.member.id}`,
                    {
                        applicant_info: this.form.applicant_info,
                        member_choice: this.form.member_choice,
                        nominee_info: this.form.nominee_info,
                    }
                )
                .then((response) => {
                    // this.isLoading = false;
                    // account_waiting_apporve
                    location.reload();
                    // console.log(response);
                })
                .catch(function (error) {
                    this.isLoading = false;
                    console.log(error);
                })
                .finally(function () {
                    this.isLoading = false;
                    // always executed
                });
        },
        initialApproveCheck() {
            let approved_wait = localStorage.getItem("approved_wait");
            if (approved_wait != "" && approved_wait == 1) {
                this.account_waiting_apporve = true;
                localStorage.removeItem("approved_wait");
            }
        },
        initialDataSet() {
            let self = this;
            self.form.applicant_info.birth_date = self.member.birth_date;
            self.form.applicant_info.emergency_contact =
                self.member.emergency_contact;
            self.form.applicant_info.father_name = self.member.father_name;
            self.form.applicant_info.gender = self.member.gender;
            self.form.applicant_info.blood_group = self.member.blood_group;
            self.form.applicant_info.bc_image = self.member.avatar_url;

            self.form.applicant_info.current_occupation =
                self.member.current_occupation;
            self.form.applicant_info.current_designation =
                self.member.current_designation;
            self.form.applicant_info.current_occupation_joining =
                self.member.current_occupation_joining;
            self.form.applicant_info.current_office_address =
                self.member.current_office_address;

            self.form.applicant_info.mobile = self.member.mobile;
            self.form.applicant_info.formattedNumber =
                self.member.formatted_number;
            self.form.applicant_info.country_code = self.member.country_code;

            self.form.applicant_info.email = self.member.email;
            self.form.applicant_info.mother_name = self.member.mother_name;
            self.form.applicant_info.name = self.member.name;
            self.form.applicant_info.nid = self.member.nid;
            self.form.applicant_info.bc_nid_front = self.member.nid_front_image;
            self.form.applicant_info.bc_nid_back = self.member.nid_back_image;

            self.form.applicant_info.permanent_address =
                self.member.permanent_address;
            self.form.applicant_info.present_address =
                self.member.present_address;

            self.form.applicant_info.bc_signature = self.member.signature_image;

            self.form.applicant_info.spouse_name = self.member.spouse_name;
            self.form.applicant_info.ref_name = self.member.ref_name;
            self.form.applicant_info.ref_mobile = self.member.ref_mobile;
            self.form.applicant_info.ref_memeber_id_no =
                self.member.ref_memeber_id_no;

            //nominee data assign
            self.form.nominee_info.birth_date = self.member.nominee.birth_date;
            self.form.nominee_info.gender = self.member.nominee.gender;
            self.form.nominee_info.nid = self.member.nominee.nid;
            self.form.nominee_info.bc_image = self.member.nominee.avatar_url;
            self.form.nominee_info.father_name =
                self.member.nominee.father_name;

            self.form.nominee_info.mobile = self.member.nominee.mobile;
            self.form.nominee_info.formattedNumber =
                self.member.nominee.formatted_number;

            self.form.nominee_info.email = self.member.nominee.email;
            self.form.nominee_info.country_code =
                self.member.nominee.country_code;

            self.form.nominee_info.mother_name =
                self.member.nominee.mother_name;
            self.form.nominee_info.name = self.member.nominee.name;

            self.form.nominee_info.bc_nid_back =
                self.member.nominee.nid_back_image;
            self.form.nominee_info.bc_nid_front =
                self.member.nominee.nid_front_image;

            self.form.nominee_info.permanent_address =
                self.member.nominee.permanent_address;
            self.form.nominee_info.professional_details =
                self.member.nominee.professional_details;
            self.form.nominee_info.relation_with_user =
                self.member.nominee.relation_with_user;

            // member choice
            self.member.member_choices.map((memberChoice, index) => {
                if (memberChoice.project_type == "area_of_dhaka_city") {
                    self.form.member_choice.project_1.prefered_area =
                        memberChoice.prefered_area;
                    self.form.member_choice.project_1.capacity_range =
                        memberChoice.capacity_range;
                    self.form.member_choice.project_1.flat_size =
                        memberChoice.flat_size;
                    self.form.member_choice.project_1.exp_bank_loan =
                        memberChoice.exp_bank_loan;
                    self.form.member_choice.project_1.num_flat_shares =
                        memberChoice.num_flat_shares;
                    self.form.member_choice.project_1.p_introducer_name =
                        memberChoice.p_introducer_name;

                    self.form.member_choice.project_1.p_introducer_member_num =
                        memberChoice.p_introducer_member_num;
                } else if (
                    memberChoice.project_type == "area_close_to_dhaka_city"
                ) {
                    self.form.member_choice.project_2.prefered_area =
                        memberChoice.prefered_area;
                    self.form.member_choice.project_2.capacity_range =
                        memberChoice.capacity_range;
                    self.form.member_choice.project_2.flat_size =
                        memberChoice.flat_size;
                    self.form.member_choice.project_2.exp_bank_loan =
                        memberChoice.exp_bank_loan;
                    self.form.member_choice.project_2.num_flat_shares =
                        memberChoice.num_flat_shares;
                    self.form.member_choice.project_2.p_introducer_name =
                        memberChoice.p_introducer_name;

                    self.form.member_choice.project_2.p_introducer_member_num =
                        memberChoice.p_introducer_member_num;
                } else if (memberChoice.project_type == "other_distict") {
                    self.form.member_choice.project_3.prefered_area =
                        memberChoice.prefered_area;
                    self.form.member_choice.project_3.capacity_range =
                        memberChoice.capacity_range;
                    self.form.member_choice.project_3.flat_size =
                        memberChoice.flat_size;
                    self.form.member_choice.project_3.exp_bank_loan =
                        memberChoice.exp_bank_loan;
                    self.form.member_choice.project_3.num_flat_shares =
                        memberChoice.num_flat_shares;
                    self.form.member_choice.project_3.p_introducer_name =
                        memberChoice.p_introducer_name;

                    self.form.member_choice.project_3.p_introducer_member_num =
                        memberChoice.p_introducer_member_num;
                }
            });
            // console.log(self.member);
        },
    },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.error {
    color: red !important;
}
.signature_img {
    width: 100%;
    height: 101px;
    border-radius: 5px;
}
</style>
