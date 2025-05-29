// ledger start
$(document).ready(function () {
    $(document).on("change", "#monthly", function () {
        console.log("chnage");
        let value = $(this).val();
        // console.log(value);
        if (value == 0) {
            $("#activeDate").css("display", "block");
        }
        if (value == 1) {
            $("#activeDate").css("display", "none");
        }
    });

    $(document).on("change", "#acc_cat", function () {
        var account_id = $(this).val();

        var div = $(this).parent().parent().parent();
        var op = " ";
        console.log(account_id);
        $.ajax({
            type: "get",
            url: "/admin/getAccountGroup",
            data: {
                id: account_id,
            },
            success: function (data) {
                console.log("dd: " + data);
                op += '<option value="0" selected disabled>Choose One</option>';
                for (var i = 0; i < data.length; i++) {
                    op +=
                        '<option value="' +
                        data[i].id +
                        '">' +
                        data[i].group_name +
                        "</option>";
                }

                div.find("#acc_group_id").html(" ");
                div.find("#acc_group_id").append(op);
            },
        });
    });

    //account group note show
    $(document).on("change", "#acc_group_id", function () {
        var group_id = $(this).val();
        console.log(group_id);
        $.ajax({
            type: "get",
            url: "/admin/getAccountGroupnote",
            data: {
                id: group_id,
            },
            success: function success(data) {
                console.log("dd: " + data);
                $("#note").val(data);
            },
        });
    });

    $(document).on("change", ".select_all", function () {
        console.log("select_all chaneg");
        if ($(this).prop("checked") == true) {
            $(".user_single_check").each(function () {
                let self = $(this);
                let userid = self.data("userid");
                console.log("user_single_check", userid);
                $(".hide_user_check_" + userid).removeAttr("disabled");
                self.prop("checked", true);
            });
            // $('.hide_user_check_'+userid).removeAttr('disabled');
        } else if ($(this).prop("checked") == false) {
            $(".user_single_check").each(function () {
                let self = $(this);
                let userid = self.data("userid");
                $(".hide_user_check_" + userid).attr("disabled", "disabled");
                self.prop("checked", false);
            });

            //  $('.hide_user_check_'+userid).attr('disabled','disabled');
        }
    });

    $(document).on("change", ".user_single_check", function () {
        var userid = $(this).data("userid");
        if ($(this).prop("checked") == true) {
            $(".hide_user_check_" + userid).removeAttr("disabled");
        } else if ($(this).prop("checked") == false) {
            $(".hide_user_check_" + userid).attr("disabled", "disabled");
        }
        // console.log(userid);
    });

    //Note: Calculate Sum based on select all
    $(document).on("change", ".select_all", function () {
        let total_amount = 0;
        if ($(this).prop("checked") == true) {
            $(".single_check_sum").each(function () {
                let self = $(this);
                if (self.prop("checked") == true) {
                    let totalamount = self.data("totalamount");
                    total_amount = total_amount + parseFloat(totalamount);
                }
            });

            total_amount > 0
                ? grand_total_fadeIn(total_amount)
                : grand_total_fadeOut();
        } else if ($(this).prop("checked") == false) {
            // grand_total_fadeOut();
            $(".single_check_sum").each(function () {
                let self = $(this);
                if (self.prop("checked") == true) {
                    let totalamount = self.data("totalamount");
                    total_amount = total_amount + parseFloat(totalamount);
                }
            });

            total_amount > 0
                ? grand_total_fadeIn(total_amount)
                : grand_total_fadeOut();
        }
    });

    // $(document).on("change", ".select_all", function () {
    //     let total_amount = 0;
    //     if ($(this).prop("checked") == true) {
    //         $(".single_check_sum").each(function () {
    //             let self = $(this);
    //             let totalamount = self.data("totalamount");
    //             total_amount = total_amount + parseFloat(totalamount);
    //             self.prop("checked", true);
    //         });
    //         // $(".user_single_check").each(function () {
    //         //     let self = $(this);
    //         //     let totalamount = self.data("totalamount");
    //         //     total_amount = total_amount + parseFloat(totalamount);
    //         //     self.prop("checked", true);
    //         // });
    //         total_amount > 0 ? grand_total_fadeIn(total_amount) : "";
    //     } else if ($(this).prop("checked") == false) {
    //         grand_total_fadeOut();
    //     }
    // });

    $(document).on("change", ".single_check_sum", function () {
        let total_amount = 0;
        $(".single_check_sum").each(function () {
            if ($(this).prop("checked") == true) {
                let self = $(this);
                let totalamount = self.data("totalamount");
                total_amount = total_amount + parseFloat(totalamount);
            }
        });
        total_amount > 0 ? grand_total_fadeIn(total_amount) : "";
    });
    // $(document).on("change", ".user_single_check", function () {
    //     let total_amount = 0;
    //     $(".user_single_check").each(function () {
    //         if ($(this).prop("checked") == true) {
    //             let self = $(this);
    //             let totalamount = self.data("totalamount");
    //             total_amount = total_amount + parseFloat(totalamount);
    //         }
    //     });
    //     total_amount > 0 ? grand_total_fadeIn(total_amount) : "";
    // });

    function grand_total_fadeIn(total_amount) {
        $(".grand_total").fadeIn();
        $("#grand_total").val(total_amount);
        $("#total_amount").html(total_amount);
    }

    function grand_total_fadeOut() {
        $(".grand_total").fadeOut();
        $("#grand_total").val("");
    }

    $(document).on("change", "#payment_type", function () {
        console.log('change');
        let payment_type = $(this).val();
        $(".m_common").fadeOut();
        $(".i_common").prop("disabled", true);
        if (payment_type === "manual") {
            $(".fee_setup").fadeIn();
            $("#fee_setup").prop("disabled", false);
            $(".document_files").fadeIn();
            $("#document_files").prop("disabled", false);
            $(".submit_btn").fadeIn();
        } else {
            $(".pay_btn").fadeIn();
        }
        // console.log(payment_type);
    });

    //payment approval
    $(document).on("change", ".payment_single_check", function () {
        let target = $(this);
        let id = target.data("id");
        if (target.prop("checked") == true) {
            $(".payment_value_one_" + id).removeAttr("disabled");
        } else if (target.prop("checked") == false) {
            $(".payment_value_one_" + id).attr("disabled", "disabled");
        }
    });
    $(document).on("change", ".select_all_payment", function () {
        let target = $(this);
        if (target.prop("checked") == true) {
            $(".payment_single_check").each(function () {
                let self = $(this);
                let id = self.data("id");
                self.prop("checked", true);
                $(".payment_value_one_" + id).removeAttr("disabled");
            });
        } else if (target.prop("checked") == false) {
            $(".payment_single_check").each(function () {
                let self = $(this);
                let id = self.data("id");
                self.prop("checked", false);
                $(".payment_value_one_" + id).attr("disabled", "disabled");
            });
        }
    });

    $(document).on("click", ".adminNavbarDropdown", function (e) {
        e.preventDefault();
        let self = $(this);
        self.toggleClass("show");
        self.next(".adminNavbarDropdown")
            .toggleClass("show")
            .attr("data-bs-popper", function (index, attr) {
                return attr == "none" ? null : "none";
            });
    });

    //Role permission jquery
    $(document).on("change", "#View_all", function (e) {
        e.preventDefault();
        let target = $(this);
        if (target.prop("checked") == true) {
            $(".View").prop("checked", true);
        } else if (target.prop("checked") == false) {
            $(".View").prop("checked", false);
        }
    });
    $(document).on("change", "#Add_all", function (e) {
        e.preventDefault();
        let target = $(this);
        if (target.prop("checked") == true) {
            $(".Add").prop("checked", true);
        } else if (target.prop("checked") == false) {
            $(".Add").prop("checked", false);
        }
    });
    $(document).on("change", "#Edit_all", function (e) {
        e.preventDefault();
        let target = $(this);
        if (target.prop("checked") == true) {
            $(".Edit").prop("checked", true);
        } else if (target.prop("checked") == false) {
            $(".Edit").prop("checked", false);
        }
    });
    $(document).on("change", "#Delete_all", function (e) {
        e.preventDefault();
        let target = $(this);
        if (target.prop("checked") == true) {
            $(".Delete").prop("checked", true);
        } else if (target.prop("checked") == false) {
            $(".Delete").prop("checked", false);
        }
    });

    //sweet alert delete...
    $(document).on("click", ".dlt_btn", function (e) {
        e.preventDefault();

        let dltform = $(this).data("dltform");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $(`form#${dltform}`).submit();
            }
        });
    });

    //click file button then image view
    $("#imgInp").change(function () {
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#uploadPreview").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    //click file button then image view(end)
});
//ledger end
