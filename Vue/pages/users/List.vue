<template>
    <div class="form-page-v1-layout">

        <div class="columns">

            <!--left-->
            <div class="column" :class="{'is-8': !page.list_view}">

                <div class="block" v-if="is_content_loading">
                    <Loader/>
                </div>

                <!--card-->
                <div class="card" v-else-if="page.assets">

                    <!--header-->
                    <header class="card-header">

                        <div class="card-header-title">
                            Users&nbsp;<span v-if="page.list && page.list.total"> ({{page.list.total}})</span>
                        </div>

                        <div class="card-header-buttons">
                            <div class="field has-addons is-pulled-right">
                                <p v-if="hasPermission('can-create-users')" class="control">
                                    <b-button tag="router-link"
                                              type="is-light"
                                              :to="{name: 'user.create'}"
                                              icon-left="plus">
                                        Create
                                    </b-button>
                                </p>

                                <p class="control">

                                    <b-button type="is-light"
                                              @click="sync()"
                                              :loading="is_btn_loading"
                                              icon-left="redo-alt">
                                    </b-button>

                                </p>
                            </div>
                        </div>

                    </header>
                    <!--/header-->

                    <!--content-->
                    <div class="card-content">



                        <div class="block" v-if="page.list">


                            <!--actions-->
                            <div class="level">

                                <!--left-->
                                <div class="level-left" >
                                    <div v-if="hasPermission('can-update-users')"
                                         class="level-item">
                                        <b-field >

                                            <b-select placeholder="- Bulk Actions -"
                                                      v-model="page.bulk_action.action">
                                                <option value="">
                                                    - Bulk Actions -
                                                </option>
                                                <option
                                                    v-for="option in page.assets.bulk_actions"
                                                    :value="option.slug"
                                                    :key="option.slug">
                                                    {{ option.name }}
                                                </option>
                                            </b-select>

                                            <b-select placeholder="- Select Status -"
                                                      v-if="page.bulk_action.action == 'bulk-change-status'"
                                                      v-model="page.bulk_action.data.status">
                                                <option value="">
                                                    - Select Status -
                                                </option>
                                                <option value=1>
                                                    Active
                                                </option>
                                                <option value=0>
                                                    Inactive
                                                </option>
                                            </b-select>


                                            <p class="control">
                                                <button class="button is-primary"
                                                        @click="actions">
                                                    Apply
                                                </button>
                                            </p>

                                        </b-field>
                                    </div>
                                </div>
                                <!--/left-->


                                <!--right-->
                                <div class="level-right">

                                    <div class="level-item">

                                        <b-field>

                                            <b-input placeholder="Search"
                                                     type="text"
                                                     icon="search"
                                                     @input="delayedSearch"
                                                     @keyup.enter.prevent="delayedSearch"
                                                     v-model="query_string.q">
                                            </b-input>

                                            <p class="control">
                                                <button class="button is-primary"
                                                        @click="getList">
                                                    Filter
                                                </button>
                                            </p>
                                            <p class="control">
                                                <button class="button is-primary"
                                                        @click="resetPage">
                                                    Reset
                                                </button>
                                            </p>
                                            <p class="control">
                                                <button class="button is-primary"
                                                        @click="toggleFilters()"
                                                        slot="trigger">
                                                    <b-icon icon="ellipsis-v"></b-icon>
                                                </button>
                                            </p>
                                        </b-field>

                                    </div>

                                </div>
                                <!--/right-->

                            </div>
                            <!--/actions-->

                            <!--filters-->
                            <div class="level" v-if="page.show_filters">

                                <div class="level-left">



                                    <div class="level-item">

                                        <b-field label="">
                                            <p class="control">
                                                <b-select placeholder="- Select a status -"
                                                          v-model="query_string.status"
                                                          @input="getList()"
                                                >
                                                    <option value="">
                                                        - Select a status -
                                                    </option>
                                                    <option value="active">
                                                        Active
                                                    </option>
                                                    <option value="inactive">
                                                        Inactive
                                                    </option>
                                                </b-select>
                                            </p>

                                            <p class="control">
                                                <b-dropdown multiple aria-role="list" @input="setRoleAction" v-model="selected_roles">
                                                    <button class="button is-primary" type="button" slot="trigger">
                                                        <span>Roles ({{ selected_roles.length }})</span>
                                                    </button>

                                                    <b-dropdown-item v-for="option in page.assets.role" v-bind:key="option.id" v-bind:value="option.slug">
                                                        <span>{{  option.name.charAt(0).toUpperCase() + option.name.slice(1) }}</span>
                                                    </b-dropdown-item>
                                                </b-dropdown>
                                            </p>
                                        </b-field>


                                    </div>

                                    <div class="level-item">
                                        <div class="field">
                                            <b-checkbox v-model="query_string.trashed"
                                                        @input="getList"
                                            >
                                                Include Trashed
                                            </b-checkbox>
                                        </div>
                                    </div>

                                </div>

                                <div class="level-right">

                                    <div class="level-item">

                                        <b-field>
                                            <b-datepicker
                                                position="is-bottom-left"
                                                placeholder="- Select a dates -"
                                                v-model="selected_date"
                                                @input="setDateRange"
                                                range>
                                            </b-datepicker>
                                        </b-field>


                                    </div>

                                </div>


                            </div>
                            <!--/filters-->


                            <!--list-->
                            <div class="block ">

                                <div class="block" style="margin-bottom: 0px;" >

                                    <div v-if="page.list_view">
                                        <ListLargeView @eReloadList="getList"/>
                                    </div>

                                    <div v-else>
                                        <ListSmallView @eReloadList="getList"/>
                                    </div>

                                </div>

                                <hr style="margin-top: 0;"/>

                            </div>
                            <!--/list-->

                            <div class="block" v-if="page.list">
                                <b-pagination  :total="page.list.total"
                                               :current.sync="page.list.current_page"
                                               :per-page="page.list.per_page"
                                               range-before=3
                                               range-after=3
                                               @change="paginate">
                                </b-pagination>
                            </div>

                        </div>
                    </div>
                    <!--/content-->

                </div>
                <!--/card-->


            </div>
            <!--/left-->

            <router-view @eReloadList="getList"></router-view>

        </div>


    </div>
</template>

<script src="./ListJs.js"></script>
