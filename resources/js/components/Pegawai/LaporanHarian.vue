<template>
<div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Data Laporan</h2>
                                        
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
													<span class="card-label font-weight-bolder text-dark" >Data Laporan</span>
													<span class="text-muted mt-1 font-weight-bold font-size-sm" v-for="(data) in infopt" :key="data.id">Data Laporan di {{ data.nama_perusahaan }}</span>
												</h3>
												<div class="card-toolbar">
													<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
														<!--begin::Trigger Modal-->
														<a href="#" class="btn btn-success font-weight-bolder font-size-sm" aria-haspopup="true" aria-expanded="false" data-toggle="modal" @click.prevent="laporanModal()">Buat Laporan</a>
                                                    </div>
                                                </div>
												
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
												<div class="card-body py-0">
													<div class="table-responsive">
													<table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                                                        <thead class="" >
                                                        <tr>
                                                            <th>No</th>
															<th>Tanggal</th>
															<th>No Pegawai</th>
															<th>Jabatan</th>
															<th>Lampiran</th>
                                                            <th>Status</th>
															<th style="text-align: center;">Action</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data,index) in alllaporan.data" :key="data.id">
                                                                    <td>{{index+1}} </td>
																	<td>{{ data.tanggal_laporan}}</td>
																	<td>{{ data.no_pegawai }}</td>
																	<!-- <td>{{ data.id_jabatan }}</td> -->
                                                                    <td>
																		<span v-for="jab in jabatan" :key="jab.id">
                                                                           <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        </span>
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
                                                                    <div v-if="data.status_laporan == 'Diproses'">
																		  <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 flaticon2-document" data-toggle="modal" @click.prevent="detailLaporan(data.id)">
                                                                          </a>
																		  <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 far fa-edit" data-toggle="modal" @click.prevent="editLaporanModal(data)">
                                                                          </a>
                                                                          <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 far fa-trash-alt" @click.prevent="hapusLaporan(data.id)">
                                                                          </a>
																	 </div>
																	 <div v-else-if="data.status_laporan == 'Ditolak'" >
                                                                          <span class="badge badge-secondary">Confirmed</span>
																	 </div>
																	  <div v-else-if="data.status_laporan == 'Diterima'" >
                                                                          <span class="badge badge-secondary">Confirmed</span>
																	 </div>
                                                                       
                                                                    </td>
																	</tr>
                                                        </tbody>
                                                    </table>

                                                </div>
												</div>
												
												<!--end::Datatable-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Content-->
								  </div>
							    </div>
					
					<!-- Modal Create -->
<div class="modal fade" id="laporan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="laporan">Data Laporan</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" @click="closeLaporan()" class="ki ki-close"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form  class="form pt-9">
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Tanggal</label>
																					<div class="col-lg-9 col-xl-6">
																						 <input v-model="form.tanggal_laporan" placeholder="Tanggal Hari Ini" type="date" class="form-control form-control-lg form-control-solid">
																					</div>
																				</div>
																				<div class="form-group row">
																					<label for="exampleTextarea" class="col-xl-3 col-lg-3 text-right col-form-label">Deskripsi</label>
																					<div class="col-lg-9 col-xl-6">
																						 <textarea v-model="form.deskripsi" placeholder="Deskripsi laporan" type="text" class="form-control form-control-lg form-control-solid"></textarea>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Lampiran File</label>
																					<div class="col-lg-9 col-xl-6">
																						 <input type="file" @change="upload" placeholder="Masukan File Surat Pendukung PDF/JPG" class="form-control form-control-lg form-control-solid">
																					</div>
																				</div>
																			</form>
                                                                               
																		</div>
																	</div>
																	<div class="modal-footer">
                                                                         <button type="button" @click="ajukanLaporan()" data-dismiss="modal"  class="btn btn-primary font-weight-bold">Submit</button>
                                                                        <button type="button" @click="closeLaporan()"  data-dismiss="modal" class="btn btn-primary font-weight-bold">Batal</button>

																	</div>
																</div>
															</div>
														</div>
					<!-- Modal Update  -->
<div class="modal fade" id="updateLaporan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="updateLaporan">Update Laporan</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" @click="closeLaporanEdit ()" class="ki ki-close"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form  class="form pt-9">
                                                                                   <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Tanggal </label>
																					<div class="col-lg-9 col-xl-6">
																						 <input v-model="form.tanggal_laporan" placeholder="Tanggal Hari Ini" type="date" class="form-control form-control-lg form-control-solid">
																					</div>
																				</div>
																				<div class="form-group row">
																					<label for="exampleTextarea" class="col-xl-3 col-lg-3 text-right col-form-label">Deskripsi</label>
																					<div class="col-lg-9 col-xl-6">
																						 <textarea v-model="form.deskripsi" placeholder="Aktifitas yang dilakukan" type="text" class="form-control form-control-lg form-control-solid"></textarea>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Lampiran</label>
																					<div class="col-lg-9 col-xl-6">
																						 <input type="file" @change="uploadupdate" placeholder="Masukan File Surat Pendukung PDF/JPG" class="form-control form-control-lg form-control-solid">
																					</div>
																				</div>
																			</form>                         
																		</div>
																	</div>
																	<div class="modal-footer">
                                                                         <button type="button" @click="updateLaporan()" data-dismiss="modal"  class="btn btn-primary font-weight-bold">Submit</button>
                                                                        <button type="button" @click="closeLaporanEdit()"  data-dismiss="modal" class="btn btn-primary font-weight-bold">Batal</button>

																	</div>
																</div>
															</div>
														</div>
					<!-- Modal Detail  -->
<div class="modal fade" id="detailLaporan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="detailLaporan">Detail Data Laporan</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" @click="closeDetail()" class="ki ki-close"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form  class="form pt-9" v-for="(data) in detlaporan" :key="data.id">
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Tanggal </label>
																					<div class="col-lg-9 col-xl-6">
																						 <div class="form-control form-control-lg form-control-solid" type="text">{{data.tanggal_laporan}}</div>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Nama Pegawai </label>
																					<div class="col-lg-9 col-xl-6">
																						 <div class="form-control form-control-lg form-control-solid" type="text">{{data.nama_lengkap}}</div>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">No Pegawai </label>
																					<div class="col-lg-9 col-xl-6">
																						 <div class="form-control form-control-lg form-control-solid" type="text">{{data.no_pegawai}}</div>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Jabatan</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">
																							<span v-for="jab in jabatan" :key="jab.id">
                                                                           				 		<a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        					</span>
																						</div>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Deskripsi</label>
																					<div class="col-lg-9 col-xl-6">
																						 <textarea disabled class="form-control form-control-lg form-control-solid" type="text" style="background-color:#F3F6F9" v-model="data.deskripsi"></textarea>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Lampiran</label>
																					<div class="col-lg-9 col-xl-6">
																						 <textarea disabled class="form-control form-control-lg form-control-solid" type="text" style="background-color:#F3F6F9" v-model="data.lampiran"></textarea>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Status</label>
																					<div class="col-lg-9 col-xl-6">
                                                                                        <div class="form-control form-control-lg form-control-solid" type="text">
                                                                                            <span class="badge badge-success" v-if="data.status_laporan == 'Diterima'" >{{data.status_laporan}}</span>
                                                                        					<span class="badge badge-danger" v-else-if="data.status_laporan == 'Ditolak'" >{{data.status_laporan}}</span>
                                                                        					<span class="badge badge-warning text-white" v-else-if="data.status_laporan == 'Diproses'" >{{data.status_laporan}}</span>
																						</div>
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
    name: "LaporanHarian",
    data() {
        return {
            infopt:[],
			preview: null,
			alllaporan:[],
			detlaporan:[],
			jabatan:[],
			fileupload:null,
			form: new Form ({
                id : "",
				tanggal_laporan : "",
                deskripsi : "",
				lampiran : "",
            }),
			search: '',
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
	watch: {
		search: function()
		 {
        	this.searchlaporan(this.search)
         },
	},
	methods:{
		searchlaporan(val) {
            if (val == "")
            {
                this.tampillaporanPegawai()
            }else {
                axios
                    .get('/api/searchlaporanpeg/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.alllaporan = response.data;
                    });
            }
        },
		upload(e){
			let files = e.target.files[0]
			this.preview = URL.createObjectURL(files)
			this.form.lampiran = files
		},
		uploadupdate(e){
			let files = e.target.files[0]
			this.preview = URL.createObjectURL(files)
			this.form.lampiran = files
		},
		onChange(e) {
                this.file = e.target.files[0];
        },
		laporanModal(){
		$("#laporan").modal("show");
		},
		closeLaporan(){
		 $("#laporan").modal("hide");
		 this.form.reset()
		},
		editLaporanModal(data){
		$("#updateLaporan").modal("show");
		 this.form.fill(data);
		},
		closeLaporanEdit(){
		$("#updateLaporan").modal("hide");
		},
		ajukanLaporan(){
			 const formData = new FormData()
            formData.set('lampiran', this.form.lampiran)
            this.form.post('/api/tambahlaporan', 
			{
                headers : { Authorization: "Bearer " + this.token },
            },formData,
			).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Mengajukan Lembur ",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $('#laporan').modal('hide')
                    this.tampillaporanPegawai()
                }
                    
                    }
                )
		},
		updateLaporan(){
			const formData = new FormData()
            formData.set('lampiran', this.form.lampiran)
            this.form.post('/api/updatelaporan', 
			{
                headers : { Authorization: "Bearer " + this.token },
            },
			{
                    id: this.form.id,
                    tanggal_laporan: this.form.tanggal_laporan,
					deskripsi: this.form.deskripsi,
					lampiran: this.form.lampiran
                
			},formData,
			).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Update Laporan ",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $('#updateLaporan').modal('hide')
                    this.tampillaporanPegawai()
                }
                    
                    }
                )
		},
		hapusLaporan(id){
		 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Laporan ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 axios.delete('/api/hapuslaporan/'+id,  {
                headers: { Authorization: "Bearer " + this.token },
                },
                )
                  Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Pengajuan",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    };
                    this.tampillaporanPegawai()

            },

            )

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
		closeDetail() {
            this.form.reset();
            $("#detailLaporan").modal("hide");
        },
		// Table
		tampillaporanPegawai(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampillaporanpegawai?page=' + page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.alllaporan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })

		},
		 getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/jabatanpegawai',{
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
            this.$axios.get('/api/infoptpeg',{
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
	
	mounted(){
		this.getpt();
		this.getJabatan();
		this.tampillaporanPegawai();
	}

}


</script>


