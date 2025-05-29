<template>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                        />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
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
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input
                            type="text"
                            class="form-control"
                            id="mobile"
                            name="mobile"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//
export default {
    name: "UserCreate",
    props: ["userGender"],
    data() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
