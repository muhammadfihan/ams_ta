<template>
   

    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Data Kehadiran Pegawai</h2>
                                        
										<div class="d-flex align-items-center font-weight-bold my-2">
										</div>
									</div>
								</div>
							</div>
						</div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
					
						<!--end::Subheader-->
						<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container mb-13">   
										<!--begin::Card-->
										<div class="card card-custom">
											<!--begin::Header-->
											<div class="card-header flex-wrap border-0 pt-6 pb-0">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark" >Data Kehadiran Pegawai</span>
													<span class="text-muted mt-1 font-weight-bold font-size-sm" v-for="(data) in infopt" :key="data.id">List Kehadiran Harian {{ data.nama_perusahaan }}</span>
												</h3>
												
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body">
												<!--begin::Search Form-->
												<!--begin::Search Form-->
												<div class="mb-10">
													<div class="row align-items-center">
														<div class="col-lg-12 col-xl-8">
															 <form>
															<div class="row align-items-center">
																<div class="col-md-4 my-2 my-md-0">
																	<div class="input-icon">
																		<input v-model="search" type="text" class="form-control form-control-solid" placeholder="Search..."  />
																		<span>
																			<i class="flaticon2-search-1 text-muted"></i>
																		</span>
																	</div>
																</div>
																<div>
																	<div>
																	<a class="btn btn-light-primary px-6 font-weight-bold">Search</a>
																</div>
																</div>
															</div>
														  </form>
														</div>
													</div>
												</div>
												<!--end::Search Form-->
												<!--end: Search Form-->
												<!--begin::Datatable-->
												<div class="table-responsive">
													<table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                                                        <thead class="" >
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Pegawai</th>
                                                            <th>Nama Pegawai</th>
                                                            <th>Tanggal</th>
                                                            <th style="text-align: center;">Jam Masuk</th>
                                                            <th style="text-align: center;">Jam Pulang</th>
                                                            <th>Jam Kerja</th>
                                                            <th style="text-align: center;">Keterangan</th> 
                                                            <th style="text-align: center;">Lokasi</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data,index) in absensipegawai.data" :key="data.id">
                                                                    <td>{{index+1}} </td>
                                                                     <td>
                                                                        <div class="ms-3">
                                                                            <p class="fw-bold mb-1">{{ data.name }}</p>
                                                                            <p class="text-muted mb-0">{{ data.email }}</p>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ data.nama_lengkap }}</td>
                                                                    <td>{{ data.tanggal }}</td>
                                                                    <td style="text-align: center;">
                                                                         <span class="badge badge-primary" >{{data.jam_masuk}}</span>
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                         <span class="badge badge-success" v-if="data.jam_pulang == null" >Bekerja</span>
                                                                        <span class="badge badge-primary" v-else-if="data.jam_pulang != null" >{{data.jam_pulang}}</span>
                                                                    </td>
                                                                    <td>{{ format(data.jam_kerja) }}</td>
                                                                     <td style="text-align: center;">
                                                                        <span class="badge badge-success" v-if="data.keterangan == 'On Time'" >{{data.keterangan}}</span>
                                                                        <span class="badge badge-danger" v-else-if="data.keterangan == 'Terlambat'" >{{data.keterangan}}</span>
																		 <span class="badge badge-primary" v-else-if="data.keterangan == 'Request Attendance'" >{{data.keterangan}}</span>
                                                                    </td>
                                                                     <td style="text-align: center;">
                                                                         <span class="badge badge-info" style="cursor:pointer" @click.prevent="mapmodal(data.latitude, data.longitude)">Detail Lokasi</span>
                                                                    </td>
                                                                   
                                                                    <td style="text-align: center;">
                                                                          <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 flaticon2-document" data-toggle="modal" data-target="#detailmodal" @click.prevent="detailabsen(data.uid)">
                                                                          </a>
                                                                       
                                                                    </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                 <Pagination align="right" :data="absensipegawai" @pagination-change-page="tampilabsen" />
												<!--end::Datatable-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Teachers-->
							</div>
							<!--end::Container-->
<div class="modal fade" id="mapmodal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
																<div class="modal-content" >
																	<div class="modal-header">
																		<h5 class="modal-title" id="mapmodal">Lokasi Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" @click="closeMap()" class="ki ki-close"></i>
																		</button>
																	</div>
																	<div class="modal-body" id="map">
																		<div >
																			
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button type="button"  data-dismiss="modal" class="btn btn-primary font-weight-bold" @click="closeMap()">Tutup</button>
																	</div>
																</div>
															</div>
														</div>                            

<div class="modal fade" id="detailmodal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="detailmodal">Detail Absen Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" @click="close()" class="ki ki-close"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form class="form pt-9" v-for="(data) in detabsen" :key="data.id">
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Foto Selfie Masuk</label>
																					<div class="col-lg-9 col-xl-6">
																						<!-- <div class="form-control form-control-lg form-control-solid" type="text"></div> -->
                                                                                        <img :src="`upload/${data.selfie_masuk}`" lass="form-control form-control-lg form-control-solid" style="height:100px; width:100px;">
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Foto Selfie Pulang</label>
																					<div class="col-lg-9 col-xl-6">
																						<!-- <div class="form-control form-control-lg form-control-solid" type="text"></div> -->
                                                                                        <img :src="`upload/${data.selfie_pulang}`" lass="form-control form-control-lg form-control-solid" style="height:100px; width:100px;">
																					</div>
																				</div>
																				
																			</form>
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button type="button"  data-dismiss="modal" class="btn btn-primary font-weight-bold" @click="close()">Tutup</button>
																	</div>
																</div>
															</div>
														</div>
</template>


<script>
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
    components: {
        'Pagination': LaravelVuePagination
    },
    data() {
        return {
			search: '',
            infopt:[],
            detabsen:[],
            absensipegawai : [],
            lon: '',
            lat: '',
            map: '',
            infoWindow: '',
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
     created() {
         this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilabsen',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absensipegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods:{
        initMap() {
        // The location of Uluru
        const uluru = { lat: -25.344, lng: 131.031 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
            position: uluru,
            map: map,
        });
        },
        
         searchabsen(val) {
            if (val == "")
            {
                this.tampilabsen()
            }else {
                axios
                    .get('/api/searchabsen/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.absensipegawai = response.data;
                    });
            }
        },
		format(time){
		if (time != null){
			return time.replace(/(?:0)?(\d+):(?:0)?(\d+).*/,'$1 Jam');
		}
        
		},
		
		convertToSeconds(hours, minutes, seconds) {
		return Number(hours) * 60 * 60 + Number(minutes) * 60 + Number(seconds);
		},
        mapmodal(latitude, longitude){
             $('#mapmodal').modal('show')
             this.latt = latitude
             this.long = longitude
            navigator.geolocation.getCurrentPosition(
                position => {
                    var lat = position.coords.latitude
                    var lon = position.coords.longitude    
                },
            )   
             console.log(parseFloat(latitude))
             console.log(parseFloat(longitude))
             const lokasi = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
            //  this.initMap();
              const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: lokasi,
            });
            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
                position: lokasi,
                map: map,
            });
         },
    	detailabsen(uid){
             $('#detailmodal').modal('show')
             axios.get('/api/detailabsen/'+uid,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detabsen = response.data.data
            })
         },
        close(){
             $('#detailmodal').modal('hide')
         },
         closeMap(){
             $('#mapmodal').modal('hide')
         },
        getpt(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/infopt',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.infopt = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
		tampilabsen(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilabsen?page=' +page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absensipegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
		},
        
    },
     watch: {
                search: function ()
                {
                    this.searchabsen(this.search)
                }
        },
    mounted(){
        this.getpt();
		this.tampilabsen();
        this.initMap();
    },
    computed: {
    
    }
    


}


</script>
<style scoped>
#map {
  height: 800px;
  /* The height is 400 pixels */
  width: 100%;
  /* The width is the width of the web page */
}

</style>


