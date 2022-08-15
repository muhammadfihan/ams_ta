<template>
<div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Informasi Pegawai</h2>
										<div class="d-flex align-items-center font-weight-bold my-2">
										</div>
									</div>
								</div>
							</div>
						</div>
   <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container mb-13">   
										<!--begin::Card-->
										<div class="card card-custom card-stretch">
											<!--begin::Header-->
											<div class="card-header py-3">
												<div class="card-title align-items-start flex-column">
													<h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
													<span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal information</span>
												</div>
												<div class="card-toolbar" v-for="(data) in pegawais" :key="data.id">
													<button type="submit" v-if="data.nama_lengkap == null" @click="showModal(data)" class="btn btn-light-danger mr-2">Klik Disini Untuk Melengkapi Data Pegawai !</button>
                                                    <button type="submit" v-else-if="data.nama_lengkap != null" @click="showModal(data)" class="btn btn-success mr-2">Perbarui Data</button>
                                                    <button type="submit" @click="ubahpassword(data)" class="btn btn-light-success mr-2">UbahPassword</button>

												</div>
											</div>
											<!--end::Header-->
											<!--begin::Form-->
											<form class="form" v-for="(data) in pegawais" :key="data.id">
												<!--begin::Body-->
												<div class="card-body">
													<div class="row">
														<label class="col-xl-3"></label>
														<div class="col-lg-9 col-xl-6">
															<h5 class="font-weight-bold mb-6">Informasi Akun</h5>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Username</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="name">{{data.name}} </div>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Email</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text">{{data.email}}</div>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Status</label>
														<div class="col-lg-9 col-xl-6">
															 <div class="form-control form-control-lg form-control-solid" type="text"><span class="badge badge-success" v-if="data.status == 'Aktif'" >{{data.status}}</span>
                                                                                        <span class="badge badge-danger" v-else-if="data.status == 'Tidak Aktif'" >{{data.status}}</span></div>
														</div>
													</div>
                                                    <div class="form-group row" v-for="(data) in datpeg" :key="data.id">
														<label class="col-xl-3 col-lg-3 col-form-label">Jumlah Kerja</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text"><span class="badge badge-primary" >{{getFormatedStringFromDays(data.jumlah_kerja)}}</span></div>
														</div>
													</div>
                                                     <div class="form-group row" v-for="(data) in datpeg" :key="data.id">
														<label class="col-xl-3 col-lg-3 col-form-label">Jatah Cuti Tahunan</label>
														<div class="col-lg-9 col-xl-6">
															<div v-if="data.jatah_cuti == null" class="form-control form-control-lg form-control-solid" type="text"><span class="badge badge-warning" style="color:white" >Anda Belum Bekerja Selama 1 Tahun</span></div>
                                                            <div v-else-if="data.jatah_cuti <= 12" class="form-control form-control-lg form-control-solid" type="text"><span class="badge badge-primary" >{{data.jatah_cuti}}</span></div>
														</div>
													</div>
													<div class="row">
														<label class="col-xl-3"></label>
														<div class="col-lg-9 col-xl-6">
															<h5 class="font-weight-bold mt-10 mb-6">Data Pegawai</h5>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Nama Lengkap</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text">{{data.nama_lengkap}}</div>
														</div>
													</div>
                                                    <div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Gender</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text">{{data.gender}}</div>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">No Pegawai</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text">{{data.no_pegawai}}</div>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Jabatan</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text"> <span v-for="jab in jabatan" :key="jab.id">
                                                                            <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        </span></div>
														</div>
													</div>
                                                     <div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Pendidikan</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text">{{data.pendidikan}}</div>
														</div>
													</div>
                                                     <div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Golongan</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text"><span v-for="gol in golongan" :key="gol.id">
                                                                            <a v-if="data.id_golongan == gol.id">{{gol.golongan}}</a>
                                                                        </span></div>
														</div>
													</div>
                                                    <div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">No KTP</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text">{{data.no_ktp}}</div>
														</div>
													</div>
                                                    <div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">No Handphone</label>
														<div class="col-lg-9 col-xl-6">
															<div class="form-control form-control-lg form-control-solid" type="text">{{data.no_hp}}</div>
														</div>
													</div>
                                                    <div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Alamat KTP</label>
														<div class="col-lg-9 col-xl-6">
															<textarea disabled class="form-control form-control-lg form-control-solid" type="text" v-model="data.alamat"></textarea>
														</div>
													</div>
												</div>
												<!--end::Body-->
											</form>
											<!--end::Form-->
										</div>
									</div>
									<!--end::Content-->
								</div>
								<!--end::Profile Personal Information-->
							</div>
    <div class="modal fade" id="editPegawai" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="editPegawai">Edit Data Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close" @click="closeModal()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																		<form @submit.prevent="updateprofil()">
																			<div class="form-group row">
                                                                                <label class="col-xl-3 col-lg-3 col-form-label">Nama Lengkap</label>
                                                                                <div class="col-lg-9 col-xl-6">
                                                                                    <input v-model="form.nama_lengkap" class="form-control form-control-lg form-control-solid" type="name"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-xl-3 col-lg-3 col-form-label">Pendidikan</label>
                                                                                <div class="col-lg-9 col-xl-6">
                                                                                    <input v-model="form.pendidikan" class="form-control form-control-lg form-control-solid" type="name"/>
                                                                                </div>
                                                                            </div>
                                                                             <div class="form-group row">
                                                                                <label class="col-xl-3 col-lg-3 col-form-label">No Identitas KTP</label>
                                                                                <div class="col-lg-9 col-xl-6">
                                                                                    <input v-model="form.no_ktp" class="form-control form-control-lg form-control-solid" type="name"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-xl-3 col-lg-3 col-form-label">No Handphone</label>
                                                                                <div class="col-lg-9 col-xl-6">
                                                                                    <input v-model="form.no_hp" class="form-control form-control-lg form-control-solid" type="name"/>
                                                                                </div>
                                                                            </div>
                                                                             <div class="form-group row">
                                                                                <label class="col-xl-3 col-lg-3 col-form-label">Gender</label>
                                                                                <div class="col-lg-9 col-xl-6">
                                                                                   <select class="form-control form-control-lg form-control-solid" v-model="form.gender">
                                                                                            <option >Laki-Laki</option>
                                                                                            <option >Perempuan</option>
                                                                                        </select>
                                                                                </div>
                                                                            </div>
                                                                             <div class="form-group row">
                                                                                <label class="col-xl-3 col-lg-3 col-form-label">Alamat</label>
                                                                                <div class="col-lg-9 col-xl-6">
                                                                                    <textarea v-model="form.alamat" class="form-control form-control-lg form-control-solid" type="name"/>
                                                                                </div>
                                                                            </div>
																		</form>
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button type="submit" @click="updateprofil()"  class="btn btn-primary font-weight-bold">Update</button>
                                                                        <button type="button"  data-dismiss="modal" @click="closeModal()" class="btn btn-primary font-weight-bold">Batal</button>
																	</div>
																</div>
															</div>
														</div>

      
							<!--begin::Container-->

							<!--end::Container-->

</template>


<script>

export default {
    name: "Profile",
    data() {
        return {
            akunpegawai:[],
            pegawais:[],
            golongan:[],
            jabatan:[],
            golongan:[],
            datpeg: [],
             form : new Form({
                id : "",
                nama_lengkap : "",
                no_ktp : "",
                no_hp : "",
                pendidikan :"",
                gender : "",
                alamat : ""
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },

    methods:{
         getFormatedStringFromDays(numberOfDays) {
            var years = Math.floor(numberOfDays / 365);
            var months = Math.floor(numberOfDays % 365 / 30);
            var days = Math.floor(numberOfDays % 365 % 30);

            return [years,'Tahun', months,'Bulan', days, 'Hari'].join(' ');

        },

         allgolongan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/golonganpegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.golongan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        updateprofil() {
              axios.post('/api/updatedata', 
               {
                    id: this.form.id,
                    nama_lengkap: this.form.nama_lengkap,
                    no_ktp: this.form.no_ktp,
                    no_hp: this.form.no_hp,
                    gender: this.form.gender,
                    alamat: this.form.alamat,
                    pendidikan: this.form.pendidikan,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Update",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    $("#editPegawai").modal("hide")
                    this.getprofile()
                }
            
            })
           
        },
        showModal(data) {
            $("#editPegawai").modal("show");
            this.form.fill({
                nama_lengkap: data.nama_lengkap,
                pendidikan: data.pendidikan,
                no_ktp: data.no_ktp,
                no_hp: data.no_hp,
                gender: data.gender,
                alamat: data.alamat,
                
            })
        },
        closeModal() {
            $("#editPegawai").modal("hide");
        },
        isibiodata() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
              this.form.post('/api/isibiodata', {
                    headers: {Authorization: "Bearer " + this.token},
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Melengkapi Biodata",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    $("#editPegawai").modal("hide")
                    this.getprofile()
                }
                
            
            }
        )
            })
        },
         lengkap() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
              this.$axios.get('/api/isibiodata', {
                    headers: {Authorization: "Bearer " + this.token},
                }).then((response) => {
                if (email != null){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                }else{
                    this.showModal()
                }
                
            
            }
        )
            })
        },
         getprofile(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getprofile',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.pegawais = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        getdatpeg(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/datpeg',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.datpeg = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        getakun(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getakun',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.akunpegawai = response.data.data;
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
        convertToRupiah(value) {
            // value = value.toString()
            value = parseFloat(value)
            let rupiah = ''
            let valueRev = value.toString().split('').reverse().join('')
            for (let i = 0; i < valueRev.length; i++) {
                if (i % 3 === 0) rupiah += `${valueRev.substr(i, 3)}.`
            }

            const rp = rupiah
                .split('', rupiah.length - 1)
                .reverse()
                .join('')
            // console.log('rupiah', isNaN(rp), rupiah.length, rp, rupiah)
            if (rupiah === 'NaN.' || rupiah === 'NaN') {
                return '...'
            }
            return `Rp ${rp}`
        },

    },
    mounted(){
        this.getprofile();
        this.getJabatan();
        this.getakun();
        this.allgolongan();
        this.getdatpeg();
    }
    


}


</script>
<style scope>

.form-control:focus {
    box-shadow: none;
    border-color: #124EB2;
}
input::placeholder {
    font-size: 12px;
}
textarea::placeholder {
    font-size: 12px;
}
.profile-button {
    background: #124EB2;
    box-shadow: none;
    border: none
}
.lengkapi-profile {
    background: #E95A09;
    box-shadow: none;
    border: none
}
.lengkapi-profile:hover {
    background: #E95A09;
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #124EB2
}

.profile-button:focus {
    background: #124EB2;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #124EB2;
    cursor: pointer
}

.labels {
    font-size: 13px
}
   
</style>


