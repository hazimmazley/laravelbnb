<template>
  <div>
      <h6 class="text-uppercase text-secondary font-weight-bolder">

          Check Availability
          <transition>
            <span v-if="noAvailability" class="text-danger">(NOT AVAILABLE)</span>
            <span v-if="hasAvailability" class="text-success">(AVAILABLE)</span>
          </transition>
          </h6>

      <div class="form-row">
          <div class="form-group col-md-6">
              <label for="from">From</label>
              <input type="text"
              v-model="from"
              name="from"
              class="form-control form-control-sm"
              placeholder="Start Date"
              @keyup.enter="check"
              :class="[{'is-invalid': this.errorFor('from')}]"
              >

            <v-errors :errors="errorFor('from')"></v-errors>
          </div>

          <div class="form-group col-md-6">
              <label for="from">To</label>
              <input type="text"
              v-model="to"
              name="to"
              class="form-control form-control-sm"
              placeholder="End Date"
              @keyup.enter="check"
            :class="[{'is-invalid': this.errorFor('to')}]"
            >

             <v-errors :errors="errorFor('to')"></v-errors>
          </div>
      </div>

      <button class="btn btn-secondary btn-block" @click="check" :disabled="loading">
          <span v-if="!loading">Check!</span>
          <span v-if="loading"><i class="fas fa-circle-notch fa-spin"></i> Checking...</span>
        </button>
  </div>
</template>

<script>
import { is404, is422} from "./../shared/utils/response";
import validationErrors from "./../shared/mixins/validationErrors"

export default {
    mixins: [validationErrors],
    props:{
        bookableId: [Number, String]
    },

    data() {
        return {
            loading: false,
            from: this.$store.state.lastSearch.from,
            to: this.$store.state.lastSearch.to,
            status: null,
        }
    },

    computed: {
        hasErrors() {
            return 422 == this.status && this.errors != null
        },

        hasAvailability() {
            return 200 == this.status;
        },

        noAvailability() {
            return 404 == this.status;
        },
    },

    methods: {
        async check() {
            this.loading = true;
            this.errors = null;

            this.$store.dispatch('setLastSearch', {
                from: this.from,
                to: this.to
            })

            try{
                this.status = (await axios.get(
                    `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
                    )).status;

                    this.$emit('availability', this.hasAvailability)
            } catch(err) {
                if (is422(err)) {
                    this.errors = err.response.data.errors
                }

                this.status = err.response.status
                this.$emit('availability', this.hasAvailability)
            }
        
            this.loading = false
        }, 
    }
}
</script>

<style scoped>
    label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: gray;
        font-weight: bolder;
    }

    .is-invalid {
        border-color: #b22222;
        background-image: none;
    }

    .invalid-feedback {
        color: #b22222
    }
</style>