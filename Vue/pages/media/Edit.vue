<script src="./EditJs.js"></script>
<template>
    <div class="column" v-if="page.assets && item">

        <div class="card">

            <!--header-->
            <header class="card-header">

                <div class="card-header-title">
                    <span>{{$vaah.limitString(item.name, 25)}}</span>
                </div>


                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button @click="$vaah.copy(item.id)"  type="is-light">
                                <small><b>#{{item.id}}</b></small>
                            </b-button>
                        </p>

                        <p class="control">
                            <b-button icon-left="save"
                                      type="is-light"
                                      :loading="is_btn_loading"
                                      @click="store()">
                                Save
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light"
                                        slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-close')">
                                    <b-icon icon="check"></b-icon>
                                    Save & Close
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-new')">
                                    <b-icon icon="plus"></b-icon>
                                    Save & New
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-clone')">
                                    <b-icon icon="copy"></b-icon>
                                    Save & Clone
                                </b-dropdown-item>

                            </b-dropdown>


                        </p>

                        <p class="control">
                            <b-button type="is-light"
                                      tag="router-link"
                                      :to="{name:'media.view', params:{id: item.id}}"
                                      icon-left="eye">
                            </b-button>
                        </p>

                        <p class="control">
                            <b-button type="is-light"
                                      @click="resetActiveItem()"
                                      icon-left="times">
                            </b-button>
                        </p>



                    </div>


                </div>

            </header>
            <!--/header-->

            <!--content-->
            <div class="card-content">

                <div class="block">


                    <b-field label="Name" :label-position="labelPosition">
                        <b-input type="text"  name="media-name" dusk="media-name"
                                 v-model="item.name"></b-input>
                    </b-field>


                    <b-field label="Title" :label-position="labelPosition">
                        <b-input type="text"  name="media-title" dusk="media-title"
                                 v-model="item.title"></b-input>
                    </b-field>

                    <b-field label="Alternate Text" :label-position="labelPosition">
                        <b-input type="text"  name="media-alt_text" dusk="media-alt_text"
                                 v-model="item.alt_text"></b-input>
                    </b-field>

                    <b-field label="Caption" :label-position="labelPosition">
                        <b-input type="textarea"  name="media-caption" dusk="media-caption"
                                 v-model="item.caption"></b-input>
                    </b-field>


                    <b-field label="Is this a downloadable media?"
                             :label-position="labelPosition">

                        <b-radio-button v-model="item.is_downloadable"
                                        name="media-downloadable"
                                        dusk="media-downloadable"
                                        type="is-success"
                                        size="is-small"
                                        :native-value="0">
                            <b-icon icon="lock-open"></b-icon>
                            <span>No</span>
                        </b-radio-button>

                        <b-radio-button v-model="item.is_downloadable"
                                        name="media-download_requires_login"
                                        dusk="media-download_requires_login"
                                        type="is-danger"
                                        size="is-small"
                                        :native-value="1">
                            <b-icon icon="lock"></b-icon>
                            <span>Yes</span>
                        </b-radio-button>

                    </b-field>

                    <div v-if="item.is_downloadable && item.download_url">

                        <b-field label="Download URL"
                                 :message="assets.download_url+item.download_url"
                                 :label-position="labelPosition">
                            <b-field expanded>
                                <b-input type="text"
                                         name="media-download_url"
                                         dusk="media-download_url"
                                         expanded
                                         placeholder="Type slug"
                                         v-model="item.download_url"></b-input>
                                <b-tooltip label="Check url availability" type="is-dark">
                                    <p class="control">
                                        <b-button v-if="downloadable_slug_available"
                                                  @click="isDownloadableSlugAvailable"
                                                  type="is-success"
                                                  icon-left="check"></b-button>
                                        <b-button v-else
                                                  @click="isDownloadableSlugAvailable"
                                                  icon-left="question"></b-button>
                                    </p>
                                </b-tooltip>
                                <b-tooltip label="Copy Link" type="is-dark">
                                    <p class="control">
                                        <b-button icon-left="copy"></b-button>
                                    </p>
                                </b-tooltip>
                            </b-field>
                        </b-field>

                    </div>

                </div>


            </div>
            <!--/content-->





        </div>




    </div>
</template>


