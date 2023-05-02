<template>
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BreadCrumb-->
        <breadcrumb :breadcrumb-data="data.breadcrumb"></breadcrumb>
        <div class="row m-content">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                    <i class="la la-gear"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Edit Template
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form" @submit.prevent="updateTemplate">
                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">

                                <div class="form-group m-form__group row"
                                     :class="errors.has('name') || validationErrors.name ? 'has-error' : ''">
                                    <label class="col-lg-3 col-form-label" for="name">Name:<span
                                            class="required">*</span></label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Name" name="name" v-validate="'required'"
                                               v-model="template.name" type="text" class="form-control m-input"
                                               placeholder="Enter Template Name">
                                        <span class="m-form__help" v-if="errors.has('name') || validationErrors.name">
                                            {{ errors.first('name') || validationErrors.name[0] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row"
                                     :class="errors.has('message') || validationErrors.message ? 'has-error' : ''">
                                    <label class="col-lg-3 col-form-label" for="message">Message:<span class="required">*</span></label>
                                    <div class="col-lg-6">
                                        <textarea  id="s-msg" data-vv-as="Message" name="message" rows="4" cols="50"
                                                  v-validate="'required|max:'+data.sms_text_size"
                                                  v-model="template.message" type="text" class="form-control m-input mb-2"
                                                  placeholder="Enter Message"></textarea>
                                        <span class="limiter">{{charactersLeft}} | {{partsLeft}} remaining</span>

                                            <div data-toggle="tooltip"
                                                 data-placement="top" title="Insert tag"
                                                 class="g-tooltip-area"
                                                 data-original-title="Insert tag">

                                                <button type="button" id="insert-tag" @click="showTag()"
                                                   class="pull-right btn btn-default btn-sm"><i class="bi bi-tags-fill"></i> Tag
                                                </button>
                                                <ul id="tag-list" class="list-group tag-list" style="display: none">
                                                    <li class="list-group-item"><a
                                                            @click.prevent="addContactItem('first_name')" href="#">First name</a></li>
                                                    <li class="list-group-item"><a
                                                            @click.prevent="addContactItem('last_name')" href="#">Last name</a></li>
                                                    <li class="list-group-item"><a
                                                            @click.prevent="addContactItem('company')"
                                                            href="#">Company</a></li>
                                                    <li class="list-group-item"><a
                                                            @click.prevent="addContactItem('street')"
                                                            href="#">Street</a></li>
                                                    <li class="list-group-item"><a
                                                            @click.prevent="addContactItem('suite')" href="#">Suite</a></li>
                                                    <li class="list-group-item"><a
                                                            @click.prevent="addContactItem('city')"
                                                            href="#">City</a></li>
                                                    <li class="list-group-item"><a
                                                            @click.prevent="addContactItem('state')" href="#">State</a></li>
                                                    <li class="list-group-item"><a
                                                            @click.prevent="addContactItem('zip')" href="#">zip</a></li>

                                                    <!--   <li  v-if="data.settings.custom_0_name" class="list-group-item"><a @click.prevent="addContactItem('custom_0')"  href="#">{{data.settings.custom_0_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_1_name" class="list-group-item"><a @click.prevent="addContactItem('custom_1')"  href="#">{{data.settings.custom_1_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_2_name" class="list-group-item"><a @click.prevent="addContactItem('custom_2')"  href="#">{{data.settings.custom_2_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_3_name" class="list-group-item"><a @click.prevent="addContactItem('custom_3')"  href="#">{{data.settings.custom_3_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_4_name" class="list-group-item"><a @click.prevent="addContactItem('custom_4')"  href="#">{{data.settings.custom_4_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_5_name" class="list-group-item"><a @click.prevent="addContactItem('custom_5')"  href="#">{{data.settings.custom_5_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_6_name" class="list-group-item"><a @click.prevent="addContactItem('custom_6')"  href="#">{{data.settings.custom_6_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_7_name" class="list-group-item"><a @click.prevent="addContactItem('custom_7')"  href="#">{{data.settings.custom_7_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_8_name" class="list-group-item"><a @click.prevent="addContactItem('custom_8')"  href="#">{{data.settings.custom_8_name}}</a></li>-->
                                                    <!--   <li  v-if="data.settings.custom_9_name" class="list-group-item"><a @click.prevent="addContactItem('custom_9')"  href="#">{{data.settings.custom_9_name}}</a></li>-->
                                                </ul>
                                            </div>


                                        <span class="m-form__help"
                                              v-if="errors.has('message') || validationErrors.message">
                                            {{ errors.first('message') || validationErrors.message[0] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->

            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
* {
    scrollbar-width: thin;
    scrollbar-color: rgba(104, 106, 102, 0.5), rgba(0, 0, 0, 0.099);
}

::-webkit-scrollbar {
    width: 5px; /* for vertical scrollbars */
    height: auto; /* for horizontal scrollbars */
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.099);
}

::-webkit-scrollbar-thumb {
    background: rgba(104, 106, 102, 0.5);
    border-radius: 30px;
}

.g-tooltip-area {
    position: relative;
    display: inline-block;
    float: right;
}

.tag-list > li > a {
    font-size: 13px;
    font-weight: 600;
    color: #015d85;
    text-decoration: none;
}

.tag-list > li:hover {
    background-color: #329d8b;

    & a {
        color: #ffffff;
    }
}

</style>

<script>
    import AppComponent from '../../components/AppComponent'

    export default {
        extends: AppComponent,

        data() {
            return {
                template: {},
                message: "",
                validationErrors: {},
                data: {}
            };
        },
        mounted() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;
                this.getTemplateById(id);
                this.bindCurrentRoute("TemplateList");
            }
            document.addEventListener('click', this.hideTag);
        },
        computed: {
            charactersLeft() {
                var char = this.template.message.length,
                    limit = this.data.sms_text_size;
                var remaining = limit - char;
                if (remaining < 0)
                    remaining = 0;

                return "Characters: " + remaining + "/" + limit;
            },
            partsLeft() {
                var parts = this.template.message.length, limit = this.data.sms_text_part,
                    part_size = this.data.sms_text_part_size;
                parts = Math.ceil(parts / part_size);
                var remaining = limit - parts;
                if (remaining < 0)
                    remaining = 0;

                return "Parts: " + remaining + "/" + limit;
            }
        },
        methods: {
            // Update Template
            updateTemplate() {
                // Update
                this.$validator.validateAll().then((result) => {
                    if (result == true) {
                        if (typeof commonLib != 'undefined') {
                            commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none'});
                        }
                        let vm = this;
                        //this.template.message = this.message;
                        this.template._method = 'PUT';
                        axios.post("api/templates/" + this.$route.params.id, this.template).then((res) => {
                            commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                            if (res.data.response_msg.type == 'success') {
                                this.template = {};
                                this.message = "";
                                this.$router.push({name: 'TemplateList'});
                            }
                            commonLib.unblockUI(".m-content");
                        })
                            .catch(function (error) {
                                vm.validationErrors = error.response.data;
                                commonLib.unblockUI(".m-content");
                            });

                    }

                });

            },
            getTemplateById(id) {
                let vm = this;
                var refUrl = 'api/templates/' + id + '/edit';
                if (typeof commonLib != 'undefined') {
                    commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none'});
                }
                axios.get(refUrl).then((res) => {
                    this.template = res.data.data;
                    //var text = this.template.message;
                    //this.template.message = text.replace('<br />',/\r?\n/g);
                    this.data = res.data;
                    this.message = res.data.message;
                    this.$setDocumentTitle(this.data.title);
                    commonLib.unblockUI(".m-content");
                })
                    .catch(function (error) {
                        console.log(error.response);
                        commonLib.unblockUI(".m-content");
                    });

            },

            addContactItem(item) {
                console.log(item);
                // let currentMessage = currentElement.innerText || currentElement.textContent;
                let cursorPosition = $("textarea#s-msg").prop('selectionStart');
                let currentMessage = $('textarea#s-msg').val();
                console.log(currentMessage);
                console.log(cursorPosition);
                currentMessage = currentMessage.substring(0, cursorPosition) + '{' + item + '}' + currentMessage.substring(cursorPosition);
                console.log(currentMessage);
                $('textarea#s-msg').val(currentMessage);
                $('#tag-list').hide();
            },

            showTag() {
                $('#tag-list').toggle();
            },
            hideTag(e) {
                // Get the element that was clicked
                const clickedElement = e.target;
                // Get the element that contains the #tag-list element
                const tagListContainer = $('#insert-tag').parent();
                // Check if the clicked element is outside the tag list container
                if (!tagListContainer.is(clickedElement) && tagListContainer.has(clickedElement).length === 0) {
                    $('#tag-list').hide();
                }
            },
        },
        beforeDestroy() {
            // Remove event listener from the document object
            document.removeEventListener('click', this.hideTag);
        }
    };
</script>
