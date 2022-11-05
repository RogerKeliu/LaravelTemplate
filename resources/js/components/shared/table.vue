<template>
  <div class="mt-6 mb-1">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow border-b border-gray-200 sm:rounded-lg">
        <div class="table-responsive w-100">
          <table class="table table-striped">
            <thead>
              <tr>
                <th
                  scope="col"
                  v-for="(item, i) in Object.keys(collection[0] ? collection[0] : [])"
                  :key="i"
                >
                  {{ item }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td
                  scope="col"
                  v-for="(item, i) in Object.values(collection[0] ? collection[0] : [])"
                  :key="i"
                >
                  {{ item ? item : "any character" }} // {{ i }}
                </td>

              </tr>
                    <tr>
                <td
                  scope="col"
                  v-for="(item, i) in Object.values(collection[1] ? collection[1] : [])"
                  :key="i"
                >
                  {{ item ? item : "any character" }} // {{ i }}
                </td>

              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
    .table-striped>tbody>tr:nth-child(odd)>td,
.table-striped>tbody>tr:nth-child(odd)>th {
   background-color: #00BFFF;
   opacity: 0.5;
 }
</style>
<script>
export default {
  data() {
    return {};
  },
  props: {
    collection: {
      default: [],
    },
  },
};
</script>
