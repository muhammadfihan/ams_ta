<template>
    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Data Laporan Pegawai</h2>
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
													<span class="card-label font-weight-bolder text-dark" >Informasi Laporan Pegawai</span>
													<span class="text-muted mt-1 font-weight-bold font-size-sm" v-for="(data) in infopt" :key="data.id">Data Laporan di {{ data.nama_perusahaan }}</span>
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
                                                            <th>Tanggal</th>
															<th>Nama Pegawai</th>
                                                            <th>No Pegawai</th>
															<th>Jabatan</th>
                                                            <th>Deskripsi</th>
															<th>Lampiran</th>
                                                            <th>Status</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data,index) in laporan.data" :key="data.id">
                                                                    <td>{{index+1}} </td>
                                                                    <td>{{ data.tanggal_laporan}}</td>
                                                                    <td>{{ data.nama_lengkap }}</td>
																	<td>{{ data.no_pegawai }}</td>
                                                                    <td>
																		<span v-for="jab in jabatan" :key="jab.id">
                                                                           <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        </span>
																	</td>
                                                                    <td>
																		<span  @click.prevent="detailLaporan(data.id)" style="cursor:pointer" class="badge badge-primary">Deskripsi</span>
																	</td>
                                                                     <td>
																		  <span class="badge badge-warning">
																			<a style="cursor:pointer;color:white" :href="`files/${data.lampiran}`"  target="_blank">File Lampiran</a></span>
																	</td>
                                                                     <td>
                                                                        <span class="badge badge-success" v-if="data.status_laporan == 'Diterima'" >{{data.status_laporan}}</span>
                                                                        <span class="badge badge-danger" v-else-if="data.status_laporan == 'Ditolak'" >{{data.status_laporan}}</span>
                                                                        <span class="badge badge-warning text-white" v-else-if="data.status_laporan == 'Diproses'" >{{data.status_laporan}}</span>
                                                                   </td>
 																	<td style="text-align: center;">
                                                                         <span v-if="data.status_laporan == 'Diproses'" @click.prevent="showModal(data)" style="cursor:pointer" class="badge badge-primary">Approvement</span>
                                                                         <span v-else-if="data.status_laporan == 'Diterima'" class="badge badge-secondary">Confirmed</span>
                                                                        <span v-else-if="data.status_laporan == 'Ditolak'" class="badge badge-secondary">Confirmed</span>
                                                                    </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
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
				
<div class="modal fade" id="laporan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="laporan">Approvement Laporan Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close" @click="closeModal()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form  class="form pt-9">
                                                                                    <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Status</label>
																					<div class="col-lg-9 col-xl-6">
																						 <select class="form-control form-control-lg form-control-solid" v-model="form.status_laporan">
                                                                                            <option >Diterima</option>
                                                                                            <option >Ditolak</option>
                                                                                        </select>
																					</div>
																				</div>
																			</form>
                                                                               
																		</div>
																	</div>
																	<div class="modal-footer">
                                                                         <button type="button"  data-dismiss="modal" @click="confirmlaporan()" class="btn btn-primary font-weight-bold">Submit</button>
                                                                        <button type="button"  data-dismiss="modal" @click="closeModal()" class="btn btn-primary font-weight-bold">Batal</button>

																	</div>
																</div>
															</div>
														</div>                                                        
<div class="modal fade" id="detailLaporan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="detailLaporan">Detail Deskripsi</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" @click="closeDetail()" class="ki ki-close"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form  class="form pt-9" v-for="(data) in detlaporan" :key="data.id">
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Deskripsi</label>
																					<div class="col-lg-9 col-xl-6">
																						 <textarea disabled class="form-control form-control-lg form-control-solid" type="text" style="background-color:#F3F6F9" v-model="data.deskripsi"></textarea>
																					</div>
																				</div>
																				</form>                         
																		</div>
																	</div>
																	<div class="modal-footer">
                                                                        <button type="button" @click="closeDetail()"  data-dismiss="modal" class="btn btn-primary font-weight-bold">Tutup</button>

																	</div>
																</div>
															</div>
														</div>
                     


</template>


<script>

export default {
    name: "Laporan",
    data() {
        return {
			search:'',
            infopt:[],
			laporan:[],
			detlaporan:[],
            jabatan:[],
            form: new Form ({
               id : "",
               status_laporan: "",
			   deskripsi:""
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
	watch:{
		search:function(){
			this.searchlaporan(this.search)
		}
	},
    methods:{
		searchlaporan(val){
			 if (val == "")
            {
                this.tampillaporan()
            }else {
                axios
                    .get('/api/searchlaporan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.laporan = response.data;
                    });
            }
		},
        // Modal 
        closeModal() {
            $("#laporan").modal("hide");
        },
        showModal(data) {
            $("#laporan").modal("show");
            this.form.fill({
                id: data.id,
                status_req: data.status_laporan,
            })
        },
        closeDetail() {
            this.form.reset();
            $("#detailLaporan").modal("hide");
        },
        // Konfirmasi Status
        confirmlaporan(){
            axios.post('/api/confirmlaporan',
                {
                    id: this.form.id,
                    status_laporan: this.form.status_laporan,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Data Berhasil Diupdate",
                        showConfirmButton: false,
                        timer: 1600,
                    }),
                     $("#laporan").modal("hide");
                    this.tampillaporan();
                }
            })
        },
        detailLaporan(id){
            $('#detailLaporan').modal('show')
            axios.get('/api/detaillaporan/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detlaporan = response.data.data
            })
        },
        // Menampilkan Semua Tabel
        tampillaporan(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampillaporan?page='+page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.laporan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
		},
        // Menampilkan Tabel Untuk Jabatan
        getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljabatan',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.jabatan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
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
    },
    mounted () {
           this.getpt();
		   this.tampillaporan();
           this.getJabatan();
    }
}

</script>


