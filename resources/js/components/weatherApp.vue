<template>
  <div class="text-white mb-8">

    <div class="places-input text-gray-800">
      <input type="search" id="address" class="form-control" placeholder="Where are we going?"/>

      <p>Selected: <strong id="address-value">none</strong></p>
    </div>

    <div class="weather-container font-sans w-128 max-w-lg rounded-lg overflow-hidden bg-gray-900 shadow-lg mt-4">

      <div class="current-weather flex items-center justify-between px-6 py-8">

        <div class="flex items-center">

          <div>

            <div class="text-6xl font-semibold">{{ currentTemp.actual }}&#176;C</div>

            <div>Feels like {{ currentTemp.feels }}&#176;c</div>

          </div>

          <div class="mx-5">

            <div class="font-semibold">{{ currentTemp.summary }}</div>

            <div class="font-semibold">{{ location.name }}</div>

          </div>

        </div>

        <div><img
          v-bind:src="'http://openweathermap.org/img/wn/' + currentTemp.icon + '@2x.png' "/></div>

      </div>

      <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">

        <div v-for="(day,index) in daily" :key="day.time" :class="{ 'mt-8' : index > 0 }" v-if="index < 5"
             class="flex items-center">

          <div class="w-1/6 text-lg text-gray-200">{{ toDayOfWeek(day.dt) }}</div>

          <div class="w-4/6 px-4 flex items-center">

            <div><img
              v-bind:src="'http://openweathermap.org/img/wn/' + day.weather[0].icon + '@2x.png' "/></div>
            <div class="ml-3">{{ day.weather[0].description }}</div>

          </div>

          <div class="w-1/6 text-right">
            <div>{{ Math.round(day.temp.max) }}&#176;C</div>
            <div>{{ Math.round(day.temp.min) }}&#176;C</div>
          </div>

        </div>

      </div>

    </div>

  </div>
</template>

<script>
  export default {
    mounted() {

      this.fetchData();

      const placesAutocomplete = places({
        appId: 'pl869LYMQK61',
        apiKey: '3271856718180d959a969e4a55b0a422',
        container: document.querySelector('#address')
      }).configure({
        type: 'city',
        aroundLatLngViaIP: false,
      });

      const $address = document.querySelector('#address-value');
      placesAutocomplete.on('change', (e) => {
        $address.textContent = e.suggestion.value;

        this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`;
        this.location.lat = e.suggestion.latlng.lat;
        this.location.lon = e.suggestion.latlng.lng;
      });

      placesAutocomplete.on('clear', function () {
        $address.textContent = 'none';
      });
    },
    watch: {
      location: {
        handler(newValue, oldValue) {
          this.fetchData()
        },
        deep: true
      }
    },
    data() {
      return {
        currentTemp: {
          actual: '',
          feels: '',
          summary: '',
          icon: '',
        },
        location: {
          name: '',
          lat: 30.967,
          lon: 31.167,
        },
        daily: [],
      }
    }
    ,
    methods: {
      fetchData() {
        fetch(`/api/weather?lat=${this.location.lat}&lon=${this.location.lon}`)
          .then(response => response.json())
          .then(data => {
            console.log(data);
            this.currentTemp.actual = Math.round(data.current.temp);
            this.currentTemp.feels = Math.round(data.current.feels_like);
            this.currentTemp.summary = data.current.weather[0].description;
            this.currentTemp.icon = data.current.weather[0].icon;
            this.currentTemp.name = data.name;


            this.daily = data.daily;
          })
      }
      ,
      toDayOfWeek(timestamp) {
        const newDate = new Date(timestamp * 1000);
        const days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];

        return days[newDate.getDay()];
      }
    }
  }
</script>
