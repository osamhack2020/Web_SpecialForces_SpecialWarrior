<template>
	<v-sheet>
		<v-tabs
			grow
			v-model="selectedTab"
			@change="$router.push(selectedTab?'/collection/day':'/collection/month')"
		>
			<v-tab>
				<v-icon>mdi-calendar-month</v-icon>
				월간
			</v-tab>
			<v-tab>
				<v-icon>mdi-calendar-today</v-icon>
				일간
			</v-tab>
		</v-tabs>
		
		<v-tabs-items v-model="selectedTab"  style="min-height:100vh">
			<v-tab-item>
				<router-view name="month"></router-view>
			</v-tab-item>
			<v-tab-item>
				<v-menu offset-y :close-on-content-click="false" transition="scroll-y-transition" >
					<template v-slot:activator="{ on, attrs }">
						<v-container>
							<v-btn
								block
								color="primary"
								dark
								v-bind="attrs"
								v-on="on"
							>
							<v-icon>mdi-calendar-search</v-icon>
							날짜 변경
							</v-btn>
						</v-container>
					</template>
					<v-card>
						<v-date-picker
							full-width
							color="primary"
							v-model="selectedDate"
							:first-day-of-week="0"
							:show-current="currentDate"
							:allowed-dates="getAllowedDates"
							locale="ko-kr"
						></v-date-picker>
					</v-card>
				</v-menu>
				<router-view name="day" :selectedDate="selectedDate"></router-view>
			</v-tab-item>
		</v-tabs-items>
	</v-sheet>
</template>

<script>
export default {
	name:'collection',
	data:()=>({
		selectedDate: null,
		currentDate: null,
		selectedTab:0,
	}),
	created(){
		this.selectedDate = this.currentDate = this.getTodayDate();
	},
	methods:{
		getTodayDate(){
			let date = new Date();
			return date.getFullYear() + '-'+ (date.getMonth()+1) + '-' + date.getDate()
		},
		getAllowedDates(date){return date <= this.currentDate},
	},
}
</script>

<style>
	.v-date-picker-title__date{
		font-size:32px;
	}
</style>