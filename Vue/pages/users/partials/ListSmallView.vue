<script src="./ListSmallViewJs.js"></script>
<template>
    <div>
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-users') ? true : false"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 checkbox-position="left"
                 :hoverable="true"
                 :row-class="setRowClass"
        >

            <template>
                <b-table-column v-slot="props" field="id" label="ID" width="85">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column v-slot="props" field="name" label="Name">
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column v-slot="props" field="email" label="Email">
                    <b-tooltip label="Copy Email" type="is-dark">
                        <vh-copy class="text-copyable"
                                 :data="props.row.email"
                                 :label="props.row.email"
                                 @copied="copiedData"
                        >
                        </vh-copy>
                    </b-tooltip>
                </b-table-column>


                <b-table-column v-slot="props" v-if="hasPermission('can-read-users')"
                                field="roles" label="Roles">
                    <b-tooltip label="View Role" type="is-dark">
                        <b-button rounded size="is-small"
                                  type="is-primary" @click="getRole(props.row)">
                            {{ props.row.active_roles_count }} / {{page.total_roles}}
                        </b-button>
                    </b-tooltip>
                </b-table-column>



                <b-table-column v-slot="props" v-if="hasPermission('can-read-users')"
                                field="actions" label=""
                                width="80">

                    <b-tooltip v-if="hasPermission('can-update-users')"
                               label="Edit" type="is-dark">
                        <b-button size="is-small"
                                  @click="setActiveItem(props.row,'user.edit')"
                                  icon-left="edit">
                        </b-button>
                    </b-tooltip>

                    <b-tooltip label="View" type="is-dark">
                        <b-button size="is-small"
                                  @click="setActiveItem(props.row)"
                                  icon-left="chevron-right">
                        </b-button>
                    </b-tooltip>

                </b-table-column>



            </template>

            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>Nothing here.</p>
                    </div>
                </section>
            </template>

        </b-table>
    </div>
</template>
