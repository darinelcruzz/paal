<template>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th>PENDIENTE</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>PENDIENTE</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
export default {
    props: ['type'],
	data() {
		return {
			data: {},
		}
	},
	methods: {
		fetch(route) {
			axios.get(route).then(({data}) => {
		       this.data = data;
		    });
		}
	},
	created() {
		this.fetch('/api/monthly/table');
	}
};
</script>