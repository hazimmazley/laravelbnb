<template>
  <div>
      <div v-if="loading">Data is loading ...</div>
      <div v-else>
          <div class="row mb-4" v-for="row in rows" :key="'row' + row">
              <div class="col" v-for="(bookable, column) in bookablesInRow(row)"
              :key="'row' + row + column"
              >
                <bookable-list-item 
                    :title="bookable.title" 
                    :content="bookable.content" 
                    :price="1000">
                </bookable-list-item>
              </div>

              <div class="col" v-for="p in placeholdersInRow(row)" :key="'placeholder' + row + p"></div>
          </div>
      </div>
  </div>
</template>

<script>
import BookableListItem from './BookableListItem'

// if register with pascal case, we can use kebab case tag
export default {
    components: {
        BookableListItem
    },

    data() {
        return {
            bookables: null,
            loading: false,
            columns: 3
        }
    },

    computed: {
         rows() {
             return this.bookables == null ? 0 : Math.ceil(this.bookables.length / this.columns)
         }
    },

    methods: {
        bookablesInRow(row) {
            return this.bookables.slice((row - 1) * this.columns, row * this.columns)
        },
        placeholdersInRow(row) {
            return this.columns - this.bookablesInRow(row).length;
        }
    },

    created() {
        this.loading = true,
        setTimeout(() => {
            this.bookables = [
                {
                    id:1,
                    title: "Villa 1",
                    content: "Villa 1"
                },
                {
                    id:2,
                    title: "Villa 2",
                    content: "Villa 2"
                },
                {
                    id:3,
                    title: "Villa 2",
                    content: "Villa 2"
                },
                {
                    id:4,
                    title: "Villa 2",
                    content: "Villa 2"
                },
                 {
                    id:5,
                    title: "Villa 2",
                    content: "Villa 2"
                },
                 {
                    id:6,
                    title: "Villa 2",
                    content: "Villa 2"
                },
                 {
                    id:7,
                    title: "Villa 2",
                    content: "Villa 2"
                },
            ];
            this.loading= false
        }, 2000)
    }
}
</script>

<style>

</style>