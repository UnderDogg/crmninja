<template>

	<div>
      <vuetable-filter-bar></vuetable-filter-bar>

      <vuetable ref="vuetable"
	    api-url="/clients"
	    :fields="fields"
      	:per-page="20"
      	:sort-order="sortOrder"
      	:append-params="moreParams"
  		pagination-path=""
      	@vuetable:pagination-data="onPaginationData"></vuetable>

  		<div class="vuetable-pagination ui basic segment grid">

        	<vuetable-pagination-info ref="paginationInfo"></vuetable-pagination-info>

        	<vuetable-pagination ref="pagination"
        	:css="css.pagination"
        	@vuetable-pagination:change-page="onChangePage"></vuetable-pagination>

    	</div>

  	</div>

</template>

<script lang="ts">

import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue'
import Vue from 'vue'
import VueEvents from 'vue-events'

Vue.use(VueEvents)

export default {
	components: {
        	Vuetable,
	      	VuetablePagination,
	      	VuetablePaginationInfo
	    },
    data () {
        return {
            sortOrder: [
            {
              field: 'name',
              sortField: 'name',
              direction: 'asc'
            }
          ],
            moreParams: {},
            fields: [
            {
              name: '__checkbox',   // <----
              title: '',
              titleClass: 'center aligned',
              dataClass: 'center aligned'
            },
            {
              name: 'name',
              sortField: 'name',
              dataClass: 'center aligned'
            },
            {
              name: 'contact',
              sortField: 'contact',
              dataClass: 'center aligned'
            },
            {
              name: 'email',
              sortField: 'email',
              dataClass: 'center aligned'
            },
            {
              name: 'client_created_at',
              title: 'Date created',
              sortField: 'client_created_at',
              dataClass: 'center aligned'
            },
            {
              name: 'last_login',
              title: 'Last login',
              sortField: 'last_login',
              dataClass: 'center aligned'
            },
            {
              name: 'balance',
              sortField: 'balance',
              dataClass: 'center aligned'             
            }
		      ],
          css: {
            table: {
              tableClass: 'table table-striped table-bordered table-hovered',
              loadingClass: 'loading',
              ascendingIcon: 'glyphicon glyphicon-chevron-up',
              descendingIcon: 'glyphicon glyphicon-chevron-down',
              handleIcon: 'glyphicon glyphicon-menu-hamburger',
            },
            pagination: {
              infoClass: 'pull-left',
              wrapperClass: 'vuetable-pagination pull-right',
              activeClass: 'btn-primary',
              disabledClass: 'disabled',
              pageClass: 'btn btn-border',
              linkClass: 'btn btn-border',
              icons: {
                first: '',
                prev: '',
                next: '',
                last: '',
              },
            }
          }
        }
    },
    //props: ['list'],
    mounted() {

      this.$events.$on('filter-set', eventData => this.onFilterSet(eventData))
      this.$events.$on('filter-reset', e => this.onFilterReset())

    },
    beforeMount: function () {

    },
    methods: {

	    onPaginationData (paginationData : any) {

	      this.$refs.pagination.setPaginationData(paginationData)
	      this.$refs.paginationInfo.setPaginationData(paginationData) 

	    },
	    onChangePage (page : any) {

			this.$refs.vuetable.changePage(page)

	    },
		onFilterSet (filterText) {

			this.moreParams = {
			    'filter': filterText
			}
			Vue.nextTick( () => this.$refs.vuetable.refresh())

		},
		onFilterReset () {
		  	this.moreParams = {}
		  	Vue.nextTick( () => this.$refs.vuetable.refresh())
		}

	}

}
</script>

<style>
  .pagination {
    margin: 0;
    float: right;
  }
  .pagination a.page {
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 10px;
    margin-right: 2px;
  }
  .pagination a.page.active {
    color: white;
    background-color: #337ab7;
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 10px;
    margin-right: 2px;
  }
  .pagination a.btn-nav {
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 7px;
    margin-right: 2px;
  }
  .pagination a.btn-nav.disabled {
    color: lightgray;
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 7px;
    margin-right: 2px;
    cursor: not-allowed;
  }
  .pagination-info {
    float: left;
  }
</style>