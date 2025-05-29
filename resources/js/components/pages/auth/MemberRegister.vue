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
                                <label for="bcs_batch" class="form-label"
                                    >BCS Batch & Cadre <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="bcs_batch"
                                    name="bcs_batch"
                                    v-model.trim="
                                        $v.form.applicant_info.bcs_batch.$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.bcs_batch
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="joining_date" class="form-label"
                                    >Joining Date <span>*</span></label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="date"
                                    id="joining_date"
                                    name="joining_date"
                                    v-model.trim="
                                        $v.form.applicant_info.joining_date
                                            .$model
                                    "
                                />
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.joining_date
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cader_id" class="form-label"
                                    >Cadre ID </label
                                ><svg width="16" height="16"></svg>

                                <input
                                    class="form-control"
                                    type="number"
                                    id="cader_id"
                                    name="cader_id"
                                    v-model.trim="
                                        $v.form.applicant_info.cader_id.$model
                                    "
                                />
                                <!-- <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.cader_id
                                            .required && additional_info_error
                                    "
                                >
                                    Field is required
                                </div> -->
                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="
                                        !$v.form.applicant_info.cader_id
                                            .numeric && additional_info_error
                                    "
                                >
                                    Field is numeric
                                </div>
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
                                <!-- <input
                                    class="form-control"
                                    type="text"
                                    id="mobile"
                                    name="mobile"
                                    value="+88"
                                    v-model.trim="
                                        $v.form.applicant_info.mobile.$model
                                    "
                                /> -->
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
                                    >Password <span>*</span></label
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
                                <label for="office_address" class="form-label"
                                    >Designation & Office Address </label
                                ><svg width="16" height="16"></svg>

                                <textarea
                                    class="form-control"
                                    id="office_address"
                                    name="office_address"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.applicant_info.office_address
                                            .$model
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
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="proof_join_cadre" class="form-label"
                                    >Proof of joining cadre service (Copy of the
                                    first joining letter), <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="proof_join_cadre"
                                    @change="joiningCadreFileChange($event)"
                                />

                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="user_join_cader_error"
                                >
                                    Field is required
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label for="proof_join_cadre" class="form-label"
                                    >Proof of designation and current station
                                    signed by the supervising authority
                                    <span>*</span></label
                                ><svg width="16" height="16"></svg>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="proof_join_cadre"
                                    @change="proofSupervisAuthorChange($event)"
                                />

                                <div
                                    class="error"
                                    style="color: red"
                                    v-if="user_supervis_auth_error"
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
                                <!-- <input
                                    class="form-control"
                                    type="text"
                                    id="nominee_mobile"
                                    name="mobile"
                                    value="+88"
                                    v-model.trim="
                                        $v.form.nominee_info.mobile.$model
                                    "
                                /> -->
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

                                <textarea
                                    class="form-control"
                                    id="relation_with_user"
                                    name="relation_with_user"
                                    rows="3"
                                    v-model.trim="
                                        $v.form.nominee_info.relation_with_user
                                            .$model
                                    "
                                ></textarea>
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
                        <div class="col-md-12">
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
                        <!-- <div class="col-md-12">
                            <label for="#">City/District preference </label>
                            <div class="row">
                                <div
                                    class="col-md-3"
                                    v-for="(new_data, key) in $v.form
                                        .member_choice.distict_pref.$each.$iter"
                                    :key="key"
                                >
                                    <div class="form-group">
                                        <select
                                            class="form-control"
                                            v-model.trim="new_data.name.$model"
                                        >
                                            <option value="" selected disabled>
                                                Select One
                                            </option>
                                            <option
                                                v-for="distict in allDisticts"
                                                :key="distict.id"
                                                :value="distict.name"
                                            >
                                                {{ distict.name }}
                                            </option>
                                        </select>

                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !new_data.name.required &&
                                            final_change_error
                                        "
                                    >
                                        Area preference in DCC is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="#">Area preference in DCC </label>
                            <div class="row">
                                <div
                                    class="col-md-3"
                                    v-for="(new_data, key) in $v.form
                                        .member_choice.pref_of_dcc.$each.$iter"
                                    :key="key"
                                >
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model.trim="new_data.name.$model"
                                        />
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !new_data.name.required &&
                                            final_change_error
                                        "
                                    >
                                        Area preference in DCC is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="#">Area pref. close to DCC </label>
                            <div class="row">
                                <div
                                    class="col-md-3"
                                    v-for="(new_data, key) in $v.form
                                        .member_choice.pref_close_dcc.$each
                                        .$iter"
                                    :key="key"
                                >
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model.trim="new_data.name.$model"
                                        />
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !new_data.name.required &&
                                            final_change_error
                                        "
                                    >
                                        Area pref. close to DCC is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="#">Capacity Range (Tk) </label>
                            <div class="row">
                                <div
                                    class="col-md-3"
                                    v-for="(new_data, key) in $v.form
                                        .member_choice.capacity_range.$each
                                        .$iter"
                                    :key="key"
                                >
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model.trim="new_data.name.$model"
                                        />
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !new_data.name.required &&
                                            final_change_error
                                        "
                                    >
                                        Area pref. close to DCC is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="#">Preferred flat size (net) </label>
                            <div class="row">
                                <div
                                    class="col-md-3"
                                    v-for="(new_data, key) in $v.form
                                        .member_choice.flat_size.$each.$iter"
                                    :key="key"
                                >
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model.trim="new_data.name.$model"
                                        />
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !new_data.name.required &&
                                            final_change_error
                                        "
                                    >
                                        Preferred flat size (net) is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="#">Expected bank loan </label>
                            <div class="row">
                                <div
                                    class="col-md-3"
                                    v-for="(new_data, key) in $v.form
                                        .member_choice.exp_bank_loan.$each
                                        .$iter"
                                    :key="key"
                                >
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model.trim="new_data.name.$model"
                                        />
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !new_data.name.required &&
                                            final_change_error
                                        "
                                    >
                                        Expected bank loan is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="#">Number of flat shares </label>
                            <div class="row">
                                <div
                                    class="col-md-3"
                                    v-for="(new_data, key) in $v.form
                                        .member_choice.num_flat_shares.$each
                                        .$iter"
                                    :key="key"
                                >
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model.trim="new_data.name.$model"
                                        />
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !new_data.name.required &&
                                            final_change_error
                                        "
                                    >
                                        Number of flat shares is required.
                                    </div>
                                </div>
                            </div>
                        </div> -->
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
    name: "MemberRegister",
    props: ["userGender"],
    data() {
        return {
            form: {
                applicant_info: {
                    name: "",
                    father_name: "",
                    mother_name: "",
                    spouse_name: "",
                    image: "",
                    bcs_batch: "",
                    joining_date: "",
                    cader_id: "",
                    birth_date: "",
                    gender: "",
                    mobile: "",
                    email: "",
                    password: "",
                    nid: "",
                    office_address: "",
                    present_address: "",
                    permanent_address: "",
                    emergency_contact: "",
                    signature: "",
                    nid_front: "",
                    nid_back: "",
                    proof_joining_cadre: "",
                    proof_signed_by_sup_author: "",
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
                    birth_date: "",
                    gender: "",
                    mobile: "",
                    relation_with_user: "",
                    nid: "",
                    professional_details: "",
                    permanent_address: "",
                    nid_front: "",
                    nid_back: "",
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
                    // pref_of_dcc: [
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    // ],
                    // pref_close_dcc: [
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    // ],

                    // flat_size: [
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    // ],
                    // exp_bank_loan: [
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    // ],
                    // num_flat_shares: [
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    // ],
                    // distict_pref: [
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    // ],
                    // capacity_range: [
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    //     {
                    //         name: "",
                    //     },
                    // ],
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
            // introducer_1: "",
            // introducer_2: "",
            // introducer_3: "",
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
                spouse_name: {
                    required: false,
                },
                image: {
                    required: false,
                },
                bcs_batch: {
                    required,
                },

                joining_date: {
                    required,
                },

                cader_id: {
                    required: false,
                    numeric,
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
                    required,
                    email,
                },
                password: {
                    required,
                    minLength: minLength(6),
                },
                nid: {
                    required,
                },
                office_address: {
                    required: false,
                },
                present_address: {
                    required: false,
                },
                permanent_address: {
                    required: false,
                },
                emergency_contact: {
                    required: false,
                },
                proof_joining_cadre: {
                    required: false,
                },
                proof_signed_by_sup_author: {
                    required: false,
                },
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
                    required,
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
                relation_with_user: {
                    required,
                },
                permanent_address: {
                    required,
                },
                professional_details: {
                    required: false,
                },
                nid: {
                    required,
                },
                nid_front: {
                    required: false,
                },
                nid_back: {
                    required: false,
                },
            },
            member_choice: {
                // distict_pref: {
                //     required: false,
                //     $each: {
                //         name: { required: false },
                //     },
                // },
                // pref_of_dcc: {
                //     required: false,
                //     $each: {
                //         name: { required: false },
                //     },
                // },
                // pref_close_dcc: {
                //     required: false,
                //     $each: {
                //         name: { required: false },
                //     },
                // },
                // capacity_range: {
                //     required: false,
                //     $each: {
                //         name: { required: false },
                //     },
                // },
                // flat_size: {
                //     required: false,
                //     $each: {
                //         name: { required: false },
                //     },
                // },
                // exp_bank_loan: {
                //     required: false,
                //     $each: {
                //         name: { required: false },
                //     },
                // },
                // num_flat_shares: {
                //     required: false,
                //     $each: {
                //         name: { required: false },
                //     },
                // },
            },
        },
    },
    created() {
        this.initialApproveCheck();
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
            // console.log(event);
            this.form.applicant_info.country_code = event.countryCode;
            this.form.applicant_info.formattedNumber = event.formattedNumber;
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
            };

            reader.readAsDataURL(file);
        },
        nomineeNIDImage(type) {
            if (type == "fontend") {
                if (this.form.nominee_info.nid_front != "") {
                    return this.form.nominee_info.nid_front;
                }
                return "/assets/images/nid_front.jpeg";
            } else {
                if (this.form.nominee_info.nid_back != "") {
                    return this.form.nominee_info.nid_back;
                }
                return "/assets/images/nid_back.png";
            }
        },
        nomineeNIDImageChange(event, type) {
            // console.log(type);
            let self = this;
            let file = event.target.files[0];
            const reader = new FileReader();
            if (type == "fontend") {
                self.nominee_nid_f_error = false;
                reader.onload = (event) => {
                    self.form.nominee_info.nid_front = event.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                self.nominee_nid_bc_error = false;
                reader.onload = (event) => {
                    self.form.nominee_info.nid_back = event.target.result;
                };

                reader.readAsDataURL(file);
            }
        },
        userNIDImage(type) {
            if (type == "front") {
                if (this.form.applicant_info.nid_front != "") {
                    return this.form.applicant_info.nid_front;
                }
                return "/assets/images/nid_front.jpeg";
            } else {
                if (this.form.applicant_info.nid_back != "") {
                    return this.form.applicant_info.nid_back;
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
                };
                this.user_nid_f_error = false;
            } else {
                reader.onload = (event) => {
                    this.form.applicant_info.nid_back = event.target.result;
                };
                this.user_nid_bc_error = false;
            }

            reader.readAsDataURL(file);
        },
        userSIGImage() {
            if (this.form.applicant_info.signature != "") {
                return this.form.applicant_info.signature;
            }
            return "/assets/images/dummy_sig.png";
        },
        userSIGImageChange(event) {
            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.applicant_info.signature = event.target.result;
            };
            this.user_signature_error = false;
            reader.readAsDataURL(file);
        },
        userPPImage() {
            if (this.form.applicant_info.image != "") {
                return this.form.applicant_info.image;
            }

            return "/assets/images/dummy_pp_image.jpg";
        },
        userNomineePPImage() {
            if (this.form.nominee_info.image != "") {
                return this.form.nominee_info.image;
            }
            return "/assets/images/dummy_pp_image.jpg";
        },
        userPPImageChange(event) {
            // console.log(event);

            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.applicant_info.image = event.target.result;
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
            };
            this.nominee_image_error = false;
            reader.readAsDataURL(file);
        },

        firstChangeHandler() {
            return true;
        },

        async nomineeInfoTabChange() {
            this.$v.$touch();
            //image validaiton
            if (this.form.nominee_info.image == "") {
                this.nominee_image_error = true;
                this.nominee_info_error = true;
                return false;
            }
            this.nominee_image_error = false;

            if (this.form.nominee_info.nid_front == "") {
                this.nominee_nid_f_error = true;
                this.nominee_info_error = true;
                return false;
            }
            this.nominee_nid_f_error = false;

            if (this.form.nominee_info.nid_back == "") {
                this.nominee_nid_bc_error = true;
                this.nominee_info_error = true;
                return false;
            }
            this.nominee_nid_bc_error = false;

            if (
                this.$v.form.nominee_info.name.$invalid ||
                this.$v.form.nominee_info.father_name.$invalid ||
                this.$v.form.nominee_info.mother_name.$invalid ||
                this.$v.form.nominee_info.birth_date.$invalid ||
                this.$v.form.nominee_info.gender.$invalid ||
                this.$v.form.nominee_info.mobile.$invalid ||
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
            //image validaiton
            if (this.form.applicant_info.image == "") {
                this.user_image_error = true;
                this.additional_info_error = true;
                return false;
            }
            this.user_image_error = false;

            if (this.form.applicant_info.signature == "") {
                this.user_signature_error = true;
                this.additional_info_error = true;
                return false;
            }
            this.user_signature_error = false;

            if (this.form.applicant_info.nid_front == "") {
                this.user_nid_f_error = true;
                this.additional_info_error = true;
                return false;
            }
            this.user_nid_f_error = false;

            if (this.form.applicant_info.nid_back == "") {
                this.user_nid_bc_error = true;
                this.additional_info_error = true;
                return false;
            }
            this.user_nid_bc_error = false;

            if (this.form.applicant_info.proof_joining_cadre == "") {
                this.user_join_cader_error = true;
                this.additional_info_error = true;
                return false;
            }
            this.user_join_cader_error = false;

            if (this.form.applicant_info.proof_signed_by_sup_author == "") {
                this.user_supervis_auth_error = true;
                this.additional_info_error = true;
                return false;
            }
            this.user_supervis_auth_error = false;

            if (
                this.$v.form.applicant_info.name.$invalid ||
                this.$v.form.applicant_info.father_name.$invalid ||
                this.$v.form.applicant_info.mother_name.$invalid ||
                this.$v.form.applicant_info.bcs_batch.$invalid ||
                this.$v.form.applicant_info.joining_date.$invalid ||
                this.$v.form.applicant_info.cader_id.$invalid ||
                this.$v.form.applicant_info.birth_date.$invalid ||
                this.$v.form.applicant_info.gender.$invalid ||
                this.$v.form.applicant_info.mobile.$invalid ||
                this.$v.form.applicant_info.email.$invalid ||
                this.$v.form.applicant_info.password.$invalid ||
                this.$v.form.applicant_info.ref_memeber_id_no.$invalid ||
                this.$v.form.applicant_info.ref_mobile.$invalid ||
                this.$v.form.applicant_info.ref_name.$invalid
            ) {
                this.additional_info_error = true;
                return false;
            }
            this.additional_info_error = false;
            return true;
        },
        async finalTabChange() {
            // this.$v.$touch();
            // if (
            //     this.$v.form.member_choice.pref_of_dcc.$invalid ||
            //     this.$v.form.member_choice.pref_close_dcc.$invalid ||
            //     this.$v.form.member_choice.flat_size.$invalid ||
            //     this.$v.form.member_choice.exp_bank_loan.$invalid ||
            //     this.$v.form.member_choice.num_flat_shares.$invalid
            // ) {
            //     this.final_change_error = true;
            //     return false;
            // }
            // alert("Form submitted");
            this.final_change_error = false;
            this.memberRegister();
            return true;
        },

        memberRegister() {
            this.isLoading = true;
            axios
                .post("/member-portal-register", {
                    applicant_info: this.form.applicant_info,
                    member_choice: this.form.member_choice,
                    nominee_info: this.form.nominee_info,
                })
                .then((response) => {
                    this.isLoading = false;
                    // account_waiting_apporve
                    if (response.data.status == "success") {
                        localStorage.setItem("approved_wait", 1);
                        location.reload();
                    }
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
            // this.form.applicant_info.country_code = this.member.country_code;
            // this.form.nominee_info.country_code =
            //     this.member.nominee.country_code;
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
