<script src="./ListSmallViewJs.js"></script>
<template>
    <div>
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-registrations') ? true : false"
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

                <b-table-column v-slot="props" field="status" label="Status">
                                                    <span class="tag">
                                                        {{ props.row.status }}
                                                    </span>
                </b-table-column>


                <b-table-column v-slot="props" field="actions" label=""
                                width="80">

                    <b-tooltip v-if="hasPermission('can-update-registrations')"
                               label="Edit" type="is-dark">
                        <b-button size="is-small"
                                  @click="setActiveItem(props.row,'reg.edit')"
                                  icon-left="edit">
                        </b-button>
                    </b-tooltip>

                    <b-tooltip v-if="hasPermission('can-read-registrations')" label="View" type="is-dark">
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
