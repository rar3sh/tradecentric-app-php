<template>
    <div class="row">
        <div class="col-md-4">

        </div>

        <div class="col-md-4">
            <p>{{ pagination.from }} - {{ pagination.to }} of {{ pagination.total }} </p>
        </div>

        <div class="col-md-4">
            <ul class="pagination justify-content-end">
                <li class="page-item"
                    v-on:click="$emit('paginationChanged', pagination.currentPage - 1)"
                    v-show="pagination.currentPage > 1"
                >
                    <a class="page-link" href="#">Previous</a>
                </li>

                <li class="page-item" v-for="page in pagination.lastPage"
                    :class="page === pagination.currentPage ? 'active' : ''"
                >
                    <a class="page-link" href="#" v-on:click.prevent="$emit('paginationChanged', page)">{{ page }}</a>
                </li>

                <li class="page-item" v-show="pagination.currentPage < pagination.lastPage">
                    <a class="page-link" href="#"
                       v-on:click.prevent="$emit('paginationChanged', pagination.currentPage + 1)">Next</a>
                </li>
            </ul>
        </div>

    </div>
</template>

<script>
import { PaginationModel } from '../../Models/PaginationModel.ts'

export default {
    name: 'Pagination',
    props: {
        pagination: { type: PaginationModel, required: true }
    },
}
</script>
