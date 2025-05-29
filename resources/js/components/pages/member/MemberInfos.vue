<template>
    <div>
        <vue-element-loading :active="isLoading" is-full-screen />
        <form @submit.prevent="profileUpdateSubmit" method="post">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Applicant’s Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Name <span>*</span></label
                                                >

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_name_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .name
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_name_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_name_input
                                                        "
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .name.$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .name
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_name_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .name.required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Father's Name
                                                    <span>*</span></label
                                                >

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_father_name_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .father_name
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_father_name_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_father_name_input
                                                        "
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .father_name
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .father_name
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_father_name_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .father_name
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Mother's Name
                                                    <span>*</span></label
                                                >

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_mother_name_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .mother_name
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_mother_name_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_mother_name_input
                                                        "
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .mother_name
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .mother_name
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_mother_name_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .mother_name
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Name of Spouse
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_spouse_name_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .spouse_name
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_spouse_name_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_spouse_name_input
                                                        "
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .spouse_name
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .spouse_name
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_spouse_name_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .spouse_name
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >BCS Batch & Cadre
                                                    <span>*</span>
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_bcs_batch_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .bcs_batch
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_bcs_batch_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_bcs_batch_input
                                                        "
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .bcs_batch
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .bcs_batch
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_bcs_batch_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .bcs_batch
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Joining Date <span>*</span>
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_joining_date_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .joining_date
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_joining_date_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_joining_date_input
                                                        "
                                                    >
                                                        <input
                                                            type="date"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .joining_date
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .joining_date
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_joining_date_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .joining_date
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Cadre ID
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_cader_id_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .cader_id
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_cader_id_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_cader_id_input
                                                        "
                                                    >
                                                        <input
                                                            type="number"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .cader_id
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .cader_id
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_cader_id_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .cader_id
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .cader_id
                                                                .numeric
                                                        "
                                                    >
                                                        Field is numeric
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Date of Birth
                                                    <span>*</span>
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_birth_date_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .birth_date
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_birth_date_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_birth_date_input
                                                        "
                                                    >
                                                        <input
                                                            type="date"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .birth_date
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .birth_date
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_birth_date_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .birth_date
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                >
                                                    Gender <span>*</span>
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_gender_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .gender
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_gender_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_gender_input
                                                        "
                                                    >
                                                        <select
                                                            class="form-select"
                                                            name="gender"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .gender
                                                                    .$model
                                                            "
                                                        >
                                                            <option
                                                                selected="selected"
                                                                disabled
                                                            >
                                                                Choose One
                                                            </option>
                                                            <option
                                                                v-for="(
                                                                    gender, key
                                                                ) in userGender"
                                                                :key="key"
                                                                :value="key"
                                                            >
                                                                {{ gender }}
                                                            </option>
                                                        </select>

                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .gender
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_gender_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .gender.required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-form-label"
                                                    >Mobile Number
                                                    <span>*</span>:
                                                </label>

                                                <div class="">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_mobile_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                this.form
                                                                    .applicant_info
                                                                    .formattedNumber
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_mobile_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_mobile_input
                                                        "
                                                    >
                                                        <VuePhoneNumberInput
                                                            :default-country-code="
                                                                form
                                                                    .applicant_info
                                                                    .country_code
                                                            "
                                                            v-model="
                                                                $v.form
                                                                    .applicant_info
                                                                    .mobile
                                                                    .$model
                                                            "
                                                            @update="
                                                                applicent_mobile_number
                                                            "
                                                        />

                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .mobile
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_mobile_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .applicant_info
                                                                .mobile.required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Emergency Contact :
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !applicent_emergency_contact_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .applicant_info
                                                                    .emergency_contact
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'applicent_emergency_contact_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            applicent_emergency_contact_input
                                                        "
                                                    >
                                                        <textarea
                                                            class="form-control"
                                                            id="emergency_contact"
                                                            name="emergency_contact"
                                                            rows="3"
                                                            v-model.trim="
                                                                $v.form
                                                                    .applicant_info
                                                                    .emergency_contact
                                                                    .$model
                                                            "
                                                        ></textarea>

                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .applicant_info
                                                                    .emergency_contact
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'applicent_emergency_contact_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >Email Address <span>*</span></label
                                >

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="!applicent_email_input"
                                    >
                                        <p class="m-0 pt-2">
                                            {{ form.applicant_info.email }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_email_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="applicent_email_input"
                                    >
                                        <input
                                            type="email"
                                            name="name"
                                            class="form-control"
                                            id="name"
                                            v-model.trim="
                                                $v.form.applicant_info.email
                                                    .$model
                                            "
                                        />
                                        <a
                                            v-if="
                                                $v.form.applicant_info.email
                                                    .required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_email_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>

                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !$v.form.applicant_info.email
                                                .required
                                        "
                                    >
                                        Field is required
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !$v.form.applicant_info.email.email
                                        "
                                    >
                                        Field is Email
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >Password</label
                                >

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="!applicent_password_input"
                                    >
                                        <!-- <p class="m-0 pt-2">
                                            {{
                                                form.applicant_info
                                                    .password
                                            }}
                                        </p> -->
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_password_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="applicent_password_input"
                                    >
                                        <input
                                            type="password"
                                            name="name"
                                            class="form-control"
                                            id="name"
                                            v-model.trim="
                                                $v.form.applicant_info.password
                                                    .$model
                                            "
                                        />
                                        <a
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_password_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !$v.form.applicant_info.password
                                                .minLength
                                        "
                                    >
                                        Password must have at least
                                        {{
                                            $v.form.applicant_info.password
                                                .$params.minLength.min
                                        }}
                                        letters.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >National ID Number <span>*</span></label
                                >

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="!applicent_nid_input"
                                    >
                                        <p class="m-0 pt-2">
                                            {{ form.applicant_info.nid }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_nid_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="applicent_nid_input"
                                    >
                                        <input
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            id="name"
                                            v-model.trim="
                                                $v.form.applicant_info.nid
                                                    .$model
                                            "
                                        />
                                        <a
                                            v-if="
                                                $v.form.applicant_info.nid
                                                    .required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_nid_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>

                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !$v.form.applicant_info.nid.required
                                        "
                                    >
                                        Field is required
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >Designation & Office Address
                                </label>

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="!applicent_office_address_input"
                                    >
                                        <p class="m-0 pt-2">
                                            {{
                                                form.applicant_info
                                                    .office_address
                                            }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_office_address_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="applicent_office_address_input"
                                    >
                                        <textarea
                                            class="form-control"
                                            id="office_address"
                                            name="office_address"
                                            rows="3"
                                            v-model.trim="
                                                $v.form.applicant_info
                                                    .office_address.$model
                                            "
                                        ></textarea>

                                        <a
                                            v-if="
                                                $v.form.applicant_info
                                                    .office_address.required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_office_address_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >Present Address
                                </label>

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="!applicent_present_address_input"
                                    >
                                        <p class="m-0 pt-2">
                                            {{
                                                form.applicant_info
                                                    .present_address
                                            }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_present_address_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="applicent_present_address_input"
                                    >
                                        <textarea
                                            class="form-control"
                                            id="present_address"
                                            name="present_address"
                                            rows="3"
                                            v-model.trim="
                                                $v.form.applicant_info
                                                    .present_address.$model
                                            "
                                        ></textarea>

                                        <a
                                            v-if="
                                                $v.form.applicant_info
                                                    .present_address.required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_present_address_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >Permanent Address
                                </label>

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="
                                            !applicent_permanent_address_input
                                        "
                                    >
                                        <p class="m-0 pt-2">
                                            {{
                                                form.applicant_info
                                                    .permanent_address
                                            }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_permanent_address_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="applicent_permanent_address_input"
                                    >
                                        <textarea
                                            class="form-control"
                                            id="permanent_address"
                                            name="permanent_address"
                                            rows="3"
                                            v-model.trim="
                                                $v.form.applicant_info
                                                    .permanent_address.$model
                                            "
                                        ></textarea>

                                        <a
                                            v-if="
                                                $v.form.applicant_info
                                                    .permanent_address.required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_permanent_address_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="user_img"
                                >Signature <span>*</span>
                            </label>
                            <input
                                type="file"
                                class="form-control-file"
                                id="signature"
                                @change="userSIGImageChange($event)"
                            />
                            <img
                                :src="userSIGImage()"
                                alt=""
                                class="img-fluid"
                                style="height: 185px; width: 100%"
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

                        <div class="col-md-6">
                            <label for="user_img"
                                >NID Front Side <span>*</span>
                            </label>
                            <input
                                type="file"
                                class="form-control-file"
                                id="signature"
                                @change="userNIDImageChange($event, 'front')"
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

                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label
                                            for="proof_join_cadre"
                                            class="form-label"
                                            >Proof of joining cadre service
                                            (Copy of the first joining letter),
                                            <span>*</span></label
                                        ><svg width="16" height="16"></svg>
                                        <input
                                            type="file"
                                            class="form-control-file"
                                            id="proof_join_cadre"
                                            @change="
                                                joiningCadreFileChange($event)
                                            "
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
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label
                                            for="proof_join_cadre"
                                            class="form-label"
                                            >Proof of designation and current
                                            station signed by the supervising
                                            authority <span>*</span></label
                                        ><svg width="16" height="16"></svg>
                                        <input
                                            type="file"
                                            class="form-control-file"
                                            id="proof_join_cadre"
                                            @change="
                                                proofSupervisAuthorChange(
                                                    $event
                                                )
                                            "
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
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >Reference Name *
                                </label>

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="!applicent_permanent_ref_name"
                                    >
                                        <p class="m-0 pt-2">
                                            {{ form.applicant_info.ref_name }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_permanent_ref_name'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="applicent_permanent_ref_name"
                                    >
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="ref_name"
                                            name="ref_name"
                                            v-model.trim="
                                                $v.form.applicant_info.ref_name
                                                    .$model
                                            "
                                        />

                                        <a
                                            v-if="
                                                $v.form.applicant_info
                                                    .permanent_address.required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_permanent_ref_name'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >Reference Mobile <span>*</span>
                                </label>

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="!applicent_permanent_ref_mobile"
                                    >
                                        <p class="m-0 pt-2">
                                            {{ form.applicant_info.ref_mobile }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_permanent_ref_mobile'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="applicent_permanent_ref_mobile"
                                    >
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="ref_name"
                                            name="ref_name"
                                            v-model.trim="
                                                $v.form.applicant_info
                                                    .ref_mobile.$model
                                            "
                                        />

                                        <a
                                            v-if="
                                                $v.form.applicant_info
                                                    .ref_mobile.required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_permanent_ref_mobile'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-5 col-form-label"
                                    >Reference Member Id Number
                                    <span>*</span>
                                </label>

                                <div class="col-sm-7">
                                    <div
                                        class="hidden_field"
                                        v-if="
                                            !applicent_permanent_ref_memeber_id_no
                                        "
                                    >
                                        <p class="m-0 pt-2">
                                            {{
                                                form.applicant_info
                                                    .ref_memeber_id_no
                                            }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'applicent_permanent_ref_memeber_id_no'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="
                                            applicent_permanent_ref_memeber_id_no
                                        "
                                    >
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="ref_name"
                                            name="ref_name"
                                            v-model.trim="
                                                $v.form.applicant_info
                                                    .ref_memeber_id_no.$model
                                            "
                                        />

                                        <a
                                            v-if="
                                                $v.form.applicant_info
                                                    .ref_memeber_id_no.required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'applicent_permanent_ref_memeber_id_no'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-center">
                    <h3>Nominee’s Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Name of Nominee
                                                    <span>*</span></label
                                                >

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !nominee_name_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .nominee_info
                                                                    .name
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'nominee_name_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            nominee_name_input
                                                        "
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .nominee_info
                                                                    .name.$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .nominee_info
                                                                    .name
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'nominee_name_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .nominee_info
                                                                .name.required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Father's Name
                                                    <span>*</span></label
                                                >

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !nominee_father_name_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .nominee_info
                                                                    .father_name
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'nominee_father_name_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            nominee_father_name_input
                                                        "
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .nominee_info
                                                                    .father_name
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .nominee_info
                                                                    .father_name
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'nominee_father_name_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .nominee_info
                                                                .father_name
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Mother's Name
                                                    <span>*</span></label
                                                >

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !nominee_mother_name_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .nominee_info
                                                                    .mother_name
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'nominee_mother_name_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            nominee_mother_name_input
                                                        "
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .nominee_info
                                                                    .mother_name
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .nominee_info
                                                                    .mother_name
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'nominee_mother_name_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .nominee_info
                                                                .mother_name
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >Date of Birth<span>*</span>
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !nominee_birth_date_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .nominee_info
                                                                    .birth_date
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'nominee_birth_date_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            nominee_birth_date_input
                                                        "
                                                    >
                                                        <input
                                                            type="date"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .nominee_info
                                                                    .birth_date
                                                                    .$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .nominee_info
                                                                    .birth_date
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'nominee_birth_date_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>
                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .nominee_info
                                                                .birth_date
                                                                .required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                >
                                                    Gender <span>*</span>
                                                </label>

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !nominee_gender_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .nominee_info
                                                                    .gender
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'nominee_gender_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            nominee_gender_input
                                                        "
                                                    >
                                                        <select
                                                            class="form-select"
                                                            name="gender"
                                                            v-model.trim="
                                                                $v.form
                                                                    .nominee_info
                                                                    .gender
                                                                    .$model
                                                            "
                                                        >
                                                            <option
                                                                selected="selected"
                                                                disabled
                                                            >
                                                                Choose One
                                                            </option>
                                                            <option
                                                                v-for="(
                                                                    gender, key
                                                                ) in userGender"
                                                                :key="key"
                                                                :value="key"
                                                            >
                                                                {{ gender }}
                                                            </option>
                                                        </select>

                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .nominee_info
                                                                    .gender
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'nominee_gender_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .nominee_info
                                                                .gender.required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-form-label"
                                                    >Mobile Number
                                                    <span>*</span>:
                                                </label>

                                                <div class="">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !nominee_mobile_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .nominee_info
                                                                    .formattedNumber
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'nominee_mobile_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>

                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            nominee_mobile_input
                                                        "
                                                    >
                                                        <VuePhoneNumberInput
                                                            :default-country-code="
                                                                form
                                                                    .nominee_info
                                                                    .country_code
                                                            "
                                                            v-model="
                                                                $v.form
                                                                    .nominee_info
                                                                    .mobile
                                                                    .$model
                                                            "
                                                            @update="
                                                                nominee_mobile_number
                                                            "
                                                        />

                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .nominee_info
                                                                    .mobile
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'nominee_mobile_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .nominee_info
                                                                .mobile.required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    for="name"
                                                    class="col-sm-5 col-form-label"
                                                    >National ID Number
                                                    <span>*</span></label
                                                >

                                                <div class="col-sm-7">
                                                    <div
                                                        class="hidden_field"
                                                        v-if="
                                                            !nominee_nid_input
                                                        "
                                                    >
                                                        <p class="m-0 pt-2">
                                                            {{
                                                                form
                                                                    .nominee_info
                                                                    .nid
                                                            }}
                                                        </p>
                                                        <a
                                                            class="edit"
                                                            style="color: green:z-index:999;"
                                                            @click.prevent="
                                                                showInputField(
                                                                    'nominee_nid_input'
                                                                )
                                                            "
                                                            ><i
                                                                class="fa fa-pencil-square-o"
                                                                aria-hidden="true"
                                                            ></i
                                                        ></a>
                                                    </div>
                                                    <div
                                                        class="hidden_field"
                                                        v-if="nominee_nid_input"
                                                    >
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            id="name"
                                                            v-model.trim="
                                                                $v.form
                                                                    .nominee_info
                                                                    .nid.$model
                                                            "
                                                        />
                                                        <a
                                                            v-if="
                                                                $v.form
                                                                    .nominee_info
                                                                    .nid
                                                                    .required
                                                            "
                                                            href=""
                                                            class="close"
                                                            style="z-index: 999"
                                                            @click.prevent="
                                                                hideInputField(
                                                                    'nominee_nid_input'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-window-close"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </div>

                                                    <div
                                                        class="error"
                                                        style="color: red"
                                                        v-if="
                                                            !$v.form
                                                                .nominee_info
                                                                .nid.required
                                                        "
                                                    >
                                                        Field is required
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                        v-if="user_image_error"
                                    >
                                        Field is required
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-4 col-form-label"
                                    >Relationship with Applican</label
                                >

                                <div class="col-sm-8">
                                    <div
                                        class="hidden_field"
                                        v-if="!nominee_relation_with_user_input"
                                    >
                                        <p class="m-0 pt-2">
                                            {{
                                                form.nominee_info
                                                    .relation_with_user
                                            }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'nominee_relation_with_user_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="nominee_relation_with_user_input"
                                    >
                                        <textarea
                                            class="form-control"
                                            id="relation_with_user"
                                            name="relation_with_user"
                                            rows="3"
                                            v-model.trim="
                                                $v.form.nominee_info
                                                    .relation_with_user.$model
                                            "
                                        ></textarea>

                                        <a
                                            v-if="
                                                $v.form.nominee_info
                                                    .relation_with_user.required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'nominee_relation_with_user_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>

                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !$v.form.nominee_info
                                                .relation_with_user.required
                                        "
                                    >
                                        Field is required
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-4 col-form-label"
                                    >Professional details
                                </label>

                                <div class="col-sm-8">
                                    <div
                                        class="hidden_field"
                                        v-if="
                                            !nominee_professional_details_input
                                        "
                                    >
                                        <p class="m-0 pt-2">
                                            {{
                                                form.nominee_info
                                                    .professional_details
                                            }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'nominee_professional_details_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="
                                            nominee_professional_details_input
                                        "
                                    >
                                        <textarea
                                            class="form-control"
                                            id="professional_details"
                                            name="professional_details"
                                            rows="3"
                                            v-model.trim="
                                                $v.form.nominee_info
                                                    .professional_details.$model
                                            "
                                        ></textarea>

                                        <a
                                            v-if="
                                                $v.form.nominee_info
                                                    .professional_details
                                                    .required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'nominee_professional_details_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-2 col-form-label"
                                    >Permanent Address <span>*</span>
                                </label>

                                <div class="col-sm-10">
                                    <div
                                        class="hidden_field"
                                        v-if="!nominee_permanent_address_input"
                                    >
                                        <p class="m-0 pt-2">
                                            {{
                                                form.nominee_info
                                                    .permanent_address
                                            }}
                                        </p>
                                        <a
                                            class="edit"
                                            style="color: green:z-index:999;"
                                            @click.prevent="
                                                showInputField(
                                                    'nominee_permanent_address_input'
                                                )
                                            "
                                            ><i
                                                class="fa fa-pencil-square-o"
                                                aria-hidden="true"
                                            ></i
                                        ></a>
                                    </div>
                                    <div
                                        class="hidden_field"
                                        v-if="nominee_permanent_address_input"
                                    >
                                        <textarea
                                            class="form-control"
                                            id="permanent_address"
                                            name="permanent_address"
                                            rows="3"
                                            v-model.trim="
                                                $v.form.nominee_info
                                                    .permanent_address.$model
                                            "
                                        ></textarea>

                                        <a
                                            v-if="
                                                $v.form.nominee_info
                                                    .permanent_address.required
                                            "
                                            href=""
                                            class="close"
                                            style="z-index: 999"
                                            @click.prevent="
                                                hideInputField(
                                                    'nominee_permanent_address_input'
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-window-close"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>
                                    <div
                                        class="error"
                                        style="color: red"
                                        v-if="
                                            !$v.form.nominee_info
                                                .permanent_address.required
                                        "
                                    >
                                        Field is required
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="user_img"
                                >NID Front Side <span>*</span>
                            </label>
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

                        <div class="col-md-6">
                            <label for="signature" class="form-label"
                                >NID Back Side <span>*</span></label
                            ><svg width="16" height="16"></svg>
                            <input
                                type="file"
                                class="form-control-file"
                                id="signature"
                                @change="nomineeNIDImageChange($event, 'back')"
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
            </div>
            <div class="card">
                <div class="card-header text-center">
                    <h3>Member Choices</h3>
                </div>
                <div class="card-body">
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
                </div>
            </div>
            <div class="text-center my-3">
                <button type="submit" class="btn btn-success">
                    Profile Update
                </button>
            </div>
        </form>
    </div>
</template>

<script>
//validaiton
import { required, numeric, minLength, email } from "vuelidate/lib/validators";

//
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

//moment js
import moment from "moment";

//vue element loader
import VueElementLoading from "vue-element-loading";

export default {
    name: "MemberInfos",
    props: ["member", "userGender"],
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
                    country_code: "",
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
                    country_code: "",
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
            applicent_name_input: false,
            applicent_father_name_input: false,
            applicent_mother_name_input: false,
            applicent_spouse_name_input: false,
            applicent_bcs_batch_input: false,
            applicent_joining_date_input: false,
            applicent_cader_id_input: false,
            applicent_birth_date_input: false,
            applicent_gender_input: false,
            applicent_mobile_input: false,
            applicent_email_input: false,
            applicent_password_input: false,
            applicent_nid_input: false,
            applicent_office_address_input: false,
            applicent_present_address_input: false,
            applicent_permanent_address_input: false,
            applicent_emergency_contact_input: false,

            applicent_permanent_ref_name: false,
            applicent_permanent_ref_mobile: false,
            applicent_permanent_ref_memeber_id_no: false,
            //nominee infos
            nominee_name_input: false,
            nominee_father_name_input: false,
            nominee_mother_name_input: false,
            nominee_birth_date_input: false,
            nominee_gender_input: false,
            nominee_mobile_input: false,
            nominee_nid_input: false,
            nominee_relation_with_user_input: false,
            nominee_professional_details_input: false,
            nominee_permanent_address_input: false,

            user_image_error: false,
            user_signature_error: false,
            user_nid_f_error: false,
            user_nid_bc_error: false,
            additional_info_error: false,

            nominee_image_error: false,
            nominee_nid_f_error: false,
            nominee_nid_bc_error: false,

            account_waiting_apporve: false,
            user_join_cader_error: false,
            user_supervis_auth_error: false,

            app_avatar_url: "",
            app_avatar_signature: "",
            app_avatar_nid_front: "",
            app_avatar_nid_back: "",

            nom_avatar_url: "",
            nom_avatar_nid_front: "",
            nom_avatar_nid_back: "",

            isLoading: false,
            app_url: window.data.base_url,
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
        VuePhoneNumberInput,
        VueElementLoading,
    },
    created() {
        this.initializeData();
        this.$v.$touch();
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
        async profileUpdateSubmit() {
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
                return false;
            }
            let self = this;
            self.isLoading = true;
            await axios
                .put(
                    "/member-profile-update",
                    {
                        applicant_info: self.form.applicant_info,
                        nominee_info: self.form.nominee_info,
                        member_choice: self.form.member_choice,
                        member_id: self.member.id,
                    }
                    // {
                    //     headers: {
                    //         "Content-Type": "application/json", // Adjust the content type as per your requirement
                    //         "Access-Control-Allow-Origin": self.app_url, // Set the allowed origin
                    //     },
                    // }
                )
                .then((response) => {
                    // // account_waiting_apporve
                    if (response.data.status == "success") {
                        self.isLoading = false;
                        location.reload();
                    }
                    console.log(response);
                })
                .catch(function (error) {
                    self.isLoading = false;
                    console.log(error);
                })
                .finally(function () {
                    self.isLoading = false;
                    // always executed
                });
        },
        applicent_mobile_number(event) {
            // console.log(event);
            this.form.applicant_info.country_code = event.countryCode;
            this.form.applicant_info.formattedNumber = event.formattedNumber;
        },
        nominee_mobile_number(event) {
            console.log(event);
            this.form.nominee_info.country_code = event.countryCode;
            this.form.nominee_info.formattedNumber = event.formattedNumber;
        },

        showInputField(data) {
            let self = this;
            switch (data) {
                case "applicent_name_input":
                    self.applicent_name_input = true;
                    break;
                case "applicent_father_name_input":
                    self.applicent_father_name_input = true;
                    break;
                case "applicent_mother_name_input":
                    self.applicent_mother_name_input = true;
                    break;
                case "applicent_spouse_name_input":
                    self.applicent_spouse_name_input = true;
                    break;
                case "applicent_bcs_batch_input":
                    self.applicent_bcs_batch_input = true;
                    break;
                case "applicent_joining_date_input":
                    self.applicent_joining_date_input = true;
                    break;
                case "applicent_cader_id_input":
                    self.applicent_cader_id_input = true;
                    break;
                case "applicent_birth_date_input":
                    self.applicent_birth_date_input = true;
                    break;
                case "applicent_gender_input":
                    self.applicent_gender_input = true;
                    break;
                case "applicent_mobile_input":
                    self.applicent_mobile_input = true;
                    break;
                case "applicent_email_input":
                    self.applicent_email_input = true;
                    break;
                case "applicent_password_input":
                    self.applicent_password_input = true;
                    break;
                case "applicent_nid_input":
                    self.applicent_nid_input = true;
                    break;
                case "applicent_office_address_input":
                    self.applicent_office_address_input = true;
                    break;
                case "applicent_present_address_input":
                    self.applicent_present_address_input = true;
                    break;
                case "applicent_permanent_address_input":
                    self.applicent_permanent_address_input = true;
                    break;
                case "applicent_emergency_contact_input":
                    self.applicent_emergency_contact_input = true;
                    break;
                case "nominee_name_input":
                    self.nominee_name_input = true;
                    break;
                case "nominee_father_name_input":
                    self.nominee_father_name_input = true;
                    break;
                case "nominee_mother_name_input":
                    self.nominee_mother_name_input = true;
                    break;
                case "nominee_birth_date_input":
                    self.nominee_birth_date_input = true;
                    break;
                case "nominee_gender_input":
                    self.nominee_gender_input = true;
                    break;
                case "nominee_mobile_input":
                    self.nominee_mobile_input = true;
                    break;
                case "nominee_nid_input":
                    self.nominee_nid_input = true;
                    break;
                case "nominee_relation_with_user_input":
                    self.nominee_relation_with_user_input = true;
                    break;
                case "nominee_professional_details_input":
                    self.nominee_professional_details_input = true;
                    break;
                case "nominee_permanent_address_input":
                    self.nominee_permanent_address_input = true;
                    break;
                case "applicent_permanent_ref_name":
                    self.applicent_permanent_ref_name = true;
                    break;
                case "applicent_permanent_ref_mobile":
                    self.applicent_permanent_ref_mobile = true;
                    break;
                case "applicent_permanent_ref_memeber_id_no":
                    self.applicent_permanent_ref_memeber_id_no = true;
                    break;
                case y:
                    // code block
                    break;
                default:
                // code block
            }
        },
        hideInputField(data) {
            let self = this;
            switch (data) {
                case "applicent_name_input":
                    self.applicent_name_input = false;
                    break;
                case "applicent_father_name_input":
                    self.applicent_father_name_input = false;
                    break;
                case "applicent_mother_name_input":
                    self.applicent_mother_name_input = false;
                    break;
                case "applicent_spouse_name_input":
                    self.applicent_spouse_name_input = false;
                    break;
                case "applicent_bcs_batch_input":
                    self.applicent_bcs_batch_input = false;
                    break;
                case "applicent_joining_date_input":
                    self.applicent_joining_date_input = false;
                    break;
                case "applicent_cader_id_input":
                    self.applicent_cader_id_input = false;
                    break;
                case "applicent_birth_date_input":
                    self.applicent_birth_date_input = false;
                    break;
                case "applicent_gender_input":
                    self.applicent_gender_input = false;
                    break;
                case "applicent_mobile_input":
                    self.applicent_mobile_input = false;
                    break;
                case "applicent_email_input":
                    self.applicent_email_input = false;
                    break;
                case "applicent_password_input":
                    self.applicent_password_input = false;
                    break;
                case "applicent_nid_input":
                    self.applicent_nid_input = false;
                    break;
                case "applicent_office_address_input":
                    self.applicent_office_address_input = false;
                    break;
                case "applicent_present_address_input":
                    self.applicent_present_address_input = false;
                    break;
                case "applicent_permanent_address_input":
                    self.applicent_permanent_address_input = false;
                    break;
                case "applicent_emergency_contact_input":
                    self.applicent_emergency_contact_input = false;
                    break;
                case "nominee_name_input":
                    self.nominee_name_input = false;
                    break;
                case "nominee_father_name_input":
                    self.nominee_father_name_input = false;
                    break;
                case "nominee_mother_name_input":
                    self.nominee_mother_name_input = false;
                    break;
                case "nominee_birth_date_input":
                    self.nominee_birth_date_input = false;
                    break;
                case "nominee_gender_input":
                    self.nominee_gender_input = false;
                    break;
                case "nominee_mobile_input":
                    self.nominee_mobile_input = false;
                    break;
                case "nominee_nid_input":
                    self.nominee_nid_input = false;
                    break;
                case "nominee_relation_with_user_input":
                    self.nominee_relation_with_user_input = false;
                    break;
                case "nominee_professional_details_input":
                    self.nominee_professional_details_input = false;
                    break;
                case "nominee_permanent_address_input":
                    self.nominee_permanent_address_input = false;
                    break;
                case "applicent_permanent_ref_name":
                    self.applicent_permanent_ref_name = false;
                    break;
                case "applicent_permanent_ref_mobile":
                    self.applicent_permanent_ref_mobile = false;
                    break;
                case "applicent_permanent_ref_memeber_id_no":
                    self.applicent_permanent_ref_memeber_id_no = false;
                    break;
                case y:
                    // code block
                    break;
                default:
                // code block
            }
        },
        initializeData() {
            let self = this;
            self.form.applicant_info.name = self.member.name;
            self.form.applicant_info.father_name = self.member.father_name;
            self.form.applicant_info.mother_name = self.member.mother_name;
            self.form.applicant_info.spouse_name = self.member.spouse_name;

            //images store
            // self.form.applicant_info.image = self.member.avatar_url;
            // self.form.applicant_info.signature = self.member.signature_image;
            // self.form.applicant_info.nid_front = self.member.nid_front_image;
            // self.form.applicant_info.nid_back = self.member.nid_back_image;

            self.app_avatar_url = self.member.avatar_url;
            self.app_avatar_signature = self.member.signature_image;
            self.app_avatar_nid_front = self.member.nid_front_image;
            self.app_avatar_nid_back = self.member.nid_back_image;
            //end

            self.form.applicant_info.bcs_batch = self.member.bcs_batch;

            self.form.applicant_info.joining_date = moment(
                self.member.joining_date
            ).format("YYYY-MM-DD");

            self.form.applicant_info.cader_id = self.member.cader_id;
            self.form.applicant_info.birth_date = moment(
                self.member.birth_date
            ).format("YYYY-MM-DD");
            self.form.applicant_info.gender = self.member.gender;

            self.form.applicant_info.mobile = self.member.mobile;
            self.form.applicant_info.country_code = self.member.country_code;
            self.form.applicant_info.formattedNumber =
                self.member.formatted_number;

            self.form.applicant_info.email = self.member.email;
            self.form.applicant_info.nid = self.member.nid;
            self.form.applicant_info.office_address =
                self.member.office_address;
            self.form.applicant_info.present_address =
                self.member.present_address;
            self.form.applicant_info.permanent_address =
                self.member.permanent_address;
            self.form.applicant_info.emergency_contact =
                self.member.emergency_contact;

            self.form.applicant_info.ref_name = self.member.ref_name;
            self.form.applicant_info.ref_mobile = self.member.ref_mobile;
            self.form.applicant_info.ref_memeber_id_no =
                self.member.ref_memeber_id_no;

            //Nominee data initialize
            self.form.nominee_info.name = self.member.nominee.name;

            self.form.nominee_info.father_name =
                self.member.nominee.father_name;
            self.form.nominee_info.mother_name =
                self.member.nominee.mother_name;
            //image store
            self.nom_avatar_url = self.member.nominee.avatar_url;
            self.nom_avatar_nid_front = self.member.nominee.nid_front_image;
            self.nom_avatar_nid_back = self.member.nominee.nid_back_image;

            self.form.nominee_info.birth_date = moment(
                self.member.nominee.birth_date
            ).format("YYYY-MM-DD");
            self.form.nominee_info.gender = self.member.nominee.gender;

            self.form.nominee_info.mobile = self.member.nominee.mobile;
            self.form.nominee_info.country_code =
                self.member.nominee.country_code;
            self.form.nominee_info.formattedNumber =
                self.member.nominee.formatted_number;

            self.form.nominee_info.relation_with_user =
                self.member.nominee.relation_with_user;
            self.form.nominee_info.nid = self.member.nominee.nid;
            self.form.nominee_info.professional_details =
                self.member.nominee.professional_details;
            self.form.nominee_info.permanent_address =
                self.member.nominee.permanent_address;

            // self.form.applicant_info.proof_joining_cadre =
            //     self.member.proof_joining_cadre;
            // self.form.applicant_info.proof_signed_by_sup_author =
            //     self.member.proof_signed_by_sup_author;

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

                // self.form.member_choice.pref_of_dcc[index].name =
                //     memberChoice.pref_of_dcc;
                // self.form.member_choice.pref_close_dcc[index].name =
                //     memberChoice.pref_close_dcc;
                // self.form.member_choice.num_flat_shares[index].name =
                //     memberChoice.num_flat_shares;
                // self.form.member_choice.flat_size[index].name =
                //     memberChoice.flat_size;
                // self.form.member_choice.exp_bank_loan[index].name =
                //     memberChoice.exp_bank_loan;

                // self.form.member_choice.distict_pref[index].name =
                //     memberChoice.distict_pref;
                // self.form.member_choice.capacity_range[index].name =
                //     memberChoice.capacity_range;
                // console.log(memberChoice, index);
            });
        },
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
                    required: false,
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
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.hidden_field {
    display: flex;
    gap: 7px;
}
.hidden_field a.close {
    font-size: 35px;
    color: red;
    z-index: 999;
}
.hidden_field a.edit {
    font-size: 20px;
    margin-top: 2px;
    color: green;
    z-index: 999;
}
</style>
