const CommonMixin = {
    data() {
        return {
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
        };
    },
    methods: {
        nomineeNIDImage(type) {
            if (type == "fontend") {
                if (this.form.nominee_info.nid_front != "") {
                    return this.form.nominee_info.nid_front;
                }
                if (this.nom_avatar_nid_front != "") {
                    return this.nom_avatar_nid_front;
                }
                return "/assets/images/nid_front.jpeg";
            } else {
                if (this.form.nominee_info.nid_back != "") {
                    return this.form.nominee_info.nid_back;
                }
                if (this.nom_avatar_nid_back != "") {
                    return this.nom_avatar_nid_back;
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
                    self.nom_avatar_nid_front = event.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                self.nominee_nid_bc_error = false;
                reader.onload = (event) => {
                    self.form.nominee_info.nid_back = event.target.result;
                    self.nom_avatar_nid_back = event.target.result;
                };

                reader.readAsDataURL(file);
            }
        },
        userNomineePPImageChange(event) {
            // console.log(event);

            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.nominee_info.image = event.target.result;
                this.nom_avatar_url = event.target.result;
            };
            this.nominee_image_error = false;
            reader.readAsDataURL(file);
        },
        userNomineePPImage() {
            if (this.form.nominee_info.image != "") {
                return this.form.nominee_info.image;
            } else if (this.nom_avatar_url != "") {
                return this.nom_avatar_url;
            }
            return "/assets/images/dummy_pp_image.jpg";
        },
        userPPImageChange(event) {
            // console.log(event);

            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.applicant_info.image = event.target.result;
                this.nom_avatar_url = event.target.result;
            };
            this.user_image_error = false;
            reader.readAsDataURL(file);
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
        userNIDImage(type) {
            if (type == "front") {
                if (this.form.applicant_info.nid_front != "") {
                    return this.form.applicant_info.nid_front;
                } else if (this.app_avatar_nid_front != "") {
                    return this.app_avatar_nid_front;
                }
                return "/assets/images/nid_front.jpeg";
            } else {
                if (this.form.applicant_info.nid_back != "") {
                    return this.form.applicant_info.nid_back;
                } else if (this.app_avatar_nid_back != "") {
                    return this.app_avatar_nid_back;
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
                    this.app_avatar_nid_front = event.target.result;
                };
                this.user_nid_f_error = false;
            } else {
                reader.onload = (event) => {
                    this.form.applicant_info.nid_back = event.target.result;
                    this.app_avatar_nid_back = event.target.result;
                };
                this.user_nid_bc_error = false;
            }

            reader.readAsDataURL(file);
        },
        userSIGImage() {
            if (this.form.applicant_info.signature != "") {
                return this.form.applicant_info.signature;
            } else if (this.app_avatar_signature != "") {
                return this.app_avatar_signature;
            }
            return "/assets/images/dummy_sig.png";
        },
        userSIGImageChange(event) {
            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.applicant_info.signature = event.target.result;
                this.app_avatar_signature = event.target.result;
            };
            this.user_signature_error = false;
            reader.readAsDataURL(file);
        },
        userPPImageChange(event) {
            // console.log(event);

            let file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.form.applicant_info.image = event.target.result;
                this.app_avatar_url = event.target.result;
            };
            this.user_image_error = false;
            reader.readAsDataURL(file);
        },
        userPPImage() {
            if (this.form.applicant_info.image != "") {
                return this.form.applicant_info.image;
            }
            if (this.app_avatar_url != "") {
                return this.app_avatar_url;
            }
            return "/assets/images/dummy_pp_image.jpg";
        },
    },
};

export default CommonMixin;
