<script src="./ViewJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <div class="card" v-if="is_content_loading">
            <Loader/>
        </div>

        <div class="card" v-else-if="item">

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
                        <p v-if="hasPermission('can-update-users')" class="control">
                            <b-button icon-left="edit"
                                      type="is-light"
                                      tag="router-link"
                                      :to="{name:'user.edit', params:{id: item.id}}">
                                Edit
                            </b-button>
                        </p>

                        <p v-if="hasPermission('can-update-users')" class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 v-if="!item.deleted_at"
                                                 @click="actions('bulk-trash')"
                                >
                                    <b-icon icon="trash"></b-icon>
                                    Trash
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 v-if="item.deleted_at"
                                                 @click="actions('bulk-restore')"
                                >
                                    <b-icon icon="trash-restore"></b-icon>
                                    Restore
                                </b-dropdown-item>
                                <b-dropdown-item aria-role="listitem"
                                                 @click="confirmDelete()"
                                >
                                    <b-icon icon="eraser"></b-icon>
                                    Delete
                                </b-dropdown-item>
                                <b-dropdown-item aria-role="listitem">
                                    <b-icon icon="envelope"></b-icon>
                                    Send Welcome Email
                                </b-dropdown-item>
                                <b-dropdown-item aria-role="listitem">
                                    <b-icon icon="envelope-square"></b-icon>
                                    Send Reset Password Email
                                </b-dropdown-item>

                            </b-dropdown>


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

            <b-notification type="is-danger"
                            :closable="false"
                            class="is-light is-small"
                            v-if="item.deleted_at"
            >
                Deleted {{$vaah.fromNow(item.deleted_at)}}
            </b-notification>

            <!--content-->
            <div class="card-content is-paddingless ">



                <div class="block" >

                    <div v-if="item.avatar" class="has-text-centered has-padding-5">
                        <span class="image is-64x64" style="margin: 0 auto">
                                                <img class="is-rounded"
                                                     :src="item.avatar">
                                            </span>
                    </div>

                    <div class="b-table">

                        <div class="table-wrapper">
                            <table class="table is-hoverable">

                                <tbody>



                                <template v-for="(value, label) in item">

                                    <template v-if="label == 'status'">
                                        <TableTrStatus :value="value"
                                                       :label="label">
                                        </TableTrStatus>
                                    </template>

                                    <template v-else-if="label == 'avatar'">
                                        <TableTrUrl :value="value"
                                                       :label="label">
                                        </TableTrUrl>
                                    </template>

                                    <template v-else-if="label == 'is_active'">
                                        <TableTrStatus v-if="value == 1" :value="'Yes'"
                                                       :label="label">
                                        </TableTrStatus>
                                        <TableTrStatus v-else :value="'No'"
                                                       :label="label">
                                        </TableTrStatus>
                                    </template>

                                    <template v-else-if="label == 'created_by'">
                                        <TableTrActedBy :value="item['created_by_user']"
                                                       :label="label">
                                        </TableTrActedBy>
                                    </template>

                                    <template v-else-if="label == 'updated_by'">
                                        <TableTrActedBy :value="item['updated_by_user']"
                                                        :label="label">
                                        </TableTrActedBy>
                                    </template>

                                    <template v-else-if="label == 'deleted_by'">
                                        <TableTrActedBy :value="item['deleted_by_user']"
                                                        :label="label">
                                        </TableTrActedBy>
                                    </template>

                                    <template v-else-if="label == 'meta'">

                                        <tr>
                                            <th align="right">{{$vaah.toLabel(label)}}</th>
                                            <td >
                                                <span v-if="item.meta">
                                                    <ButtonMeta dusk="action-view_payload" :value="item.meta"/>
                                                </span>
                                            </td>
                                        </tr>

                                    </template>

                                    <template v-else-if="label == 'created_by_user'
                                      || label == 'updated_by_user' || label == 'deleted_by_user'
                                      || label == 'name'  || label == 'thumbnail' ">

                                    </template>

                                    <template v-else-if="label == 'registration_id'">
                                        <TableTrTag :value="value"
                                                    :label="label"
                                                    :is_hashed="true"
                                                    :is_copiable="true"
                                        >
                                        </TableTrTag>
                                    </template>

                                    <template v-else>
                                        <TableTrView :value="value"
                                                     :label="label"
                                                     :is_copiable="isCopiable(label)"
                                                     :is_upper_case="isUpperCase(label)">
                                        </TableTrView>
                                    </template>

                                </template>

                                </tbody>



                            </table>
                        </div>

                    </div>


                </div>
            </div>
            <!--/content-->


        </div>




    </div>
</template>


