@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
<div id="enrollment_auto">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="mb-25">
                    <a href="{{route('admin.updated.profiles.list')}}">{{ get_page_meta('title', true) }}</a>
                    <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 mt-5">


                <div class="card">
                    <div class="card-header text-center">
                        <h3>Applicant’s Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="email" class="form-control" id="name" value="{{$memberUpdateProfiles->member->name ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->name))
                                                    <small id="emailHelp" class="form-text t text-success">
                                                      Changes:  {{$memberUpdateProfiles->name ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="f_name">Father's Name</label>
                                                    <input type="email" class="form-control" id="f_name"  value="{{$memberUpdateProfiles->member->father_name ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->father_name))
                                                    <small id="f_name" class="form-text t text-success">
                                                      Changes:  {{$memberUpdateProfiles->father_name ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="m_name">Mother's Name</label>
                                                    <input type="email" class="form-control" id="m_name" value="{{$memberUpdateProfiles->member->mother_name ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->mother_name))
                                                    <small id="m_name" class="form-text t text-success">
                                                      Changes:  {{$memberUpdateProfiles->mother_name ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="s_name">Name of Spouse</label>
                                                    <input type="email" class="form-control" id="s_name" value="{{$memberUpdateProfiles->member->spouse_name ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->spouse_name))
                                                    <small id="m_name" class="form-text t text-success">
                                                      Changes:  {{$memberUpdateProfiles->spouse_name ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div>
                                                  {{-- <div class="form-group">
                                                    <label for="bcs_btct">BCS Batch & Cadre</label>
                                                    <input type="email" class="form-control" id="bcs_btct" value="{{$memberUpdateProfiles->member->bcs_batch ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->bcs_batch))
                                                    <small id="m_name" class="form-text t text-success">
                                                      Changes:  {{$memberUpdateProfiles->bcs_batch ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div> --}}
                                                  <div class="form-group">
                                                    <label for="j_date">Joining Date</label>
                                                    <input type="date" class="form-control" id="j_date" value="{{$memberUpdateProfiles->member->joining_date ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->joining_date))
                                                    <small id="m_name" class="form-text t text-success">
                                                      Changes:  {{$memberUpdateProfiles->joining_date ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="c_id">Cadre ID</label>
                                                    <input type="email" class="form-control" id="c_id" value="{{$memberUpdateProfiles->member->cader_id
                                                        ?? ''}}" readonly>
                                                      @if(!is_null($memberUpdateProfiles->cader_id))
                                                      <small id="m_name" class="form-text t text-success">
                                                        Changes:  {{$memberUpdateProfiles->cader_id ?? ''}}
                                                      </small>
                                                      @endif
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="d_o_b"> Date of Birth</label>
                                                    <input type="date" class="form-control" id="d_o_b" value="{{$memberUpdateProfiles->member->birth_date
                                                        ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->birth_date))
                                                    <small id="m_name" class="form-text t text-success">
                                                      Changes:  {{$memberUpdateProfiles->birth_date ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="Gender">Gender </label>
                                                    <input type="text" class="form-control" id="Gender" value="{{$memberUpdateProfiles->member->gender
                                                        ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->gender))
                                                    <small id="m_name" class="form-text t text-success">
                                                      Changes:  {{$memberUpdateProfiles->gender ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="mobile">Mobile Number</label>
                                                    <input type="email" class="form-control" id="mobile" value="{{$memberUpdateProfiles->member->mobile
                                                        ?? ''}}" readonly>
                                                      @if(!is_null($memberUpdateProfiles->mobile))
                                                      <small id="m_name" class="form-text  text-success">
                                                        Changes:  {{$memberUpdateProfiles->mobile ?? ''}}
                                                      </small>
                                                      @endif
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="e_c">Emergency Contact</label>
                                                    <input type="email" class="form-control" id="e_c" value="{{$memberUpdateProfiles->member->emergency_contact
                                                        ?? ''}}" readonly>
                                                     @if(!is_null($memberUpdateProfiles->emergency_contact))
                                                     <small id="m_name" class="form-text t text-success">
                                                       Changes:  {{$memberUpdateProfiles->emergency_contact ?? ''}}
                                                     </small>
                                                     @endif
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Applicant’s Image </label>
                                            <a href=""  data-toggle="modal" data-target="#appProfileChange">
                                                <img
                                                src="{{!is_null($memberUpdateProfiles->image) ? $memberUpdateProfiles->avatar_url :  $memberUpdateProfiles->member->avatar_url  }}"
                                                alt=""
                                                class="img-fluid {{!is_null($memberUpdateProfiles->image) ? 'image_change' : ''}} "
                                                style="height: 250px; width: 250px"

                                                />
                                            </a>

                                          </div>
                                          @if(!is_null($memberUpdateProfiles->image))
                                          <!-- Modal -->
                                        <div class="modal fade" id="appProfileChange" tabindex="-1" aria-labelledby="appProfileChangeLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"> Update Applicant’s Image</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div>
                                                        <table>
                                                            <tr class="text-center">
                                                                <td>OLD</td>
                                                                <td>NEW</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <img
                                                                    src="{{$memberUpdateProfiles->member->avatar_url }}"
                                                                    alt=""
                                                                    class="img-fluid {{!is_null($memberUpdateProfiles->image) ? 'image_change' : ''}} "
                                                                    style="height: 250px; width: 250px"

                                                                    />

                                                                </td>
                                                                <td>
                                                                    <img
                                                                    src="{{!is_null($memberUpdateProfiles->image) ? $memberUpdateProfiles->avatar_url :  $memberUpdateProfiles->member->avatar_url  }}"
                                                                    alt=""
                                                                    class="img-fluid {{!is_null($memberUpdateProfiles->image) ? 'image_change' : ''}} "
                                                                    style="height: 250px; width: 250px"

                                                                    />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="app_email">Email address</label>
                                    <input type="email" class="form-control" id="app_email" value="{{$memberUpdateProfiles->member->email
                                        ?? ''}}" readonly>
                                      @if(!is_null($memberUpdateProfiles->email))
                                      <small id="app_email" class="form-text  text-success">
                                        Changes:  {{$memberUpdateProfiles->email ?? ''}}
                                      </small>
                                      @endif
                                  </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="app_Password">Password</label>
                                    <input type="email" class="form-control" id="app_Password" readonly>
                                    @if(!is_null($memberUpdateProfiles->password))
                                    <small id="app_Password" class="form-text  text-success">
                                        Changes:  password
                                    </small>
                                    @endif
                                  </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="app_nid">National ID Number </label>
                                    <input type="email" class="form-control" id="app_nid" value="{{$memberUpdateProfiles->member->nid
                                        ?? ''}}" readonly>
                                     @if(!is_null($memberUpdateProfiles->nid))
                                     <small id="m_name" class="form-text  text-success">
                                       Changes:  {{$memberUpdateProfiles->nid ?? ''}}
                                     </small>
                                     @endif
                                  </div>
                            </div>

                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="app_d_a_oa">Designation & Office Address</label>
                                    <input type="email" class="form-control" id="app_d_a_oa" value="{{$memberUpdateProfiles->member->office_address
                                        ?? ''}}" readonly>
                                    @if(!is_null($memberUpdateProfiles->office_address))
                                    <small id="m_name" class="form-text  text-success">
                                      Changes:  {{$memberUpdateProfiles->office_address ?? ''}}
                                    </small>
                                    @endif
                                  </div>
                            </div> --}}

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="app_pa">Present Address</label>
                                    <input type="email" class="form-control" id="app_pa" value="{{$memberUpdateProfiles->member->present_address
                                        ?? ''}}" readonly>
                                    @if(!is_null($memberUpdateProfiles->present_address))
                                    <small id="m_name" class="form-text  text-success">
                                      Changes:  {{$memberUpdateProfiles->present_address ?? ''}}
                                    </small>
                                    @endif
                                  </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="app_pa">Permanent Address</label>
                                    <input type="email" class="form-control" id="app_pa" value="{{$memberUpdateProfiles->member->permanent_address
                                        ?? ''}}" readonly>
                                    @if(!is_null($memberUpdateProfiles->permanent_address))
                                    <small id="m_name" class="form-text  text-success">
                                      Changes:  {{$memberUpdateProfiles->permanent_address ?? ''}}
                                    </small>
                                    @endif
                                  </div>
                            </div>

                            <div class="col-md-6">
                                <label for="user_img"
                                    >Signature
                                </label>

                                <a href=""  data-toggle="modal" data-target="#appSigntureChange">
                                    <img
                                        src="{{!is_null($memberUpdateProfiles->signature) ? $memberUpdateProfiles->signature_image :  $memberUpdateProfiles->member->signature_image  }}"
                                        alt=""
                                        class="img-fluid {{!is_null($memberUpdateProfiles->signature) ? 'image_change' : ''}} "
                                        style="height: 185px; width: 100%"

                                    />
                                </a>

                                @if(!is_null($memberUpdateProfiles->signature))
                                    <!-- Modal -->
                                <div class="modal fade" id="appSigntureChange" tabindex="-1" aria-labelledby="appSigntureChangeLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> Update Signature Image</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <table>
                                                    <tr class="text-center">
                                                        <td>OLD</td>
                                                        <td>NEW</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <img
                                                            src="{{$memberUpdateProfiles->member->signature_image   }}"
                                                            alt=""
                                                            class="img-fluid {{!is_null($memberUpdateProfiles->image) ? 'image_change' : ''}} "
                                                            style="height: 185px; width: 100%"

                                                            />

                                                        </td>
                                                        <td>
                                                            <img
                                                                src="{{!is_null($memberUpdateProfiles->signature) ? $memberUpdateProfiles->signature_image :  $memberUpdateProfiles->member->signature_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->signature) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endif

                            </div>

                            <div class="col-md-6">
                                <label for="user_img"
                                    >NID Front Side
                                </label>

                                <a href=""  data-toggle="modal" data-target="#appNidFront">
                                    <img
                                        src="{{!is_null($memberUpdateProfiles->nid_front) ? $memberUpdateProfiles->nid_front_image :  $memberUpdateProfiles->member->nid_front_image  }}"
                                        alt=""
                                        class="img-fluid {{!is_null($memberUpdateProfiles->nid_front) ? 'image_change' : ''}} "
                                        style="height: 185px; width: 100%"

                                    />
                                </a>

                                @if(!is_null($memberUpdateProfiles->nid_front))
                                    <!-- Modal -->
                                <div class="modal fade" id="appNidFront" tabindex="-1" aria-labelledby="appNidFrontLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> Update Front NID Image</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <table>
                                                    <tr class="text-center">
                                                        <td>OLD</td>
                                                        <td>NEW</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <img
                                                                src="{{ $memberUpdateProfiles->member->nid_front_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->nid_front) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                        <td>
                                                            <img
                                                                src="{{!is_null($memberUpdateProfiles->nid_front) ? $memberUpdateProfiles->nid_front_image :  $memberUpdateProfiles->member->nid_front_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->nid_front) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="user_img"
                                    >NID Back Side
                                </label>

                                <a href=""  data-toggle="modal" data-target="#appNidBack">
                                    <img
                                        src="{{!is_null($memberUpdateProfiles->nid_back) ? $memberUpdateProfiles->nid_back_image :  $memberUpdateProfiles->member->nid_back_image  }}"
                                        alt=""
                                        class="img-fluid {{!is_null($memberUpdateProfiles->nid_back) ? 'image_change' : ''}} "
                                        style="height: 185px; width: 100%"

                                    />
                                </a>

                                @if(!is_null($memberUpdateProfiles->nid_back))
                                <!-- Modal -->
                                <div class="modal fade" id="appNidBack" tabindex="-1" aria-labelledby="appNidBackLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> Update NID Back Side Image</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <table>
                                                    <tr class="text-center">
                                                        <td>OLD</td>
                                                        <td>NEW</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <img
                                                                src="{{ $memberUpdateProfiles->member->nid_back_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->nid_back) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                        <td>
                                                            <img
                                                                src="{{!is_null($memberUpdateProfiles->nid_back) ? $memberUpdateProfiles->nid_back_image :  $memberUpdateProfiles->member->nid_back_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->nid_back) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endif
                            </div>


                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="prf_or_jon"> Proof of joining cadre service
                                                    (Copy of the first joining letter),</label>
                                                <input type="text" class="form-control" id="prf_or_jon" readonly>
                                                @if(!is_null($memberUpdateProfiles->proof_joining_cadre))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$memberUpdateProfiles->proof_joining_cadre ?? ''}}
                                                </small>
                                                @endif
                                              </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="prof_of_des">Proof of designation and current
                                                    station signed by the supervising
                                                    authority</label>
                                                <input type="text" class="form-control" id="prof_of_des" readonly>
                                                @if(!is_null($memberUpdateProfiles->proof_signed_by_sup_author))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$memberUpdateProfiles->proof_signed_by_sup_author ?? ''}}
                                                </small>
                                                @endif
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_pa">Reference Name </label>
                                    <input type="email" class="form-control" id="app_pa" value="{{$memberUpdateProfiles->member->ref_name
                                        ?? ''}}" readonly>
                                    @if(!is_null($memberUpdateProfiles->ref_name))
                                    <small id="m_name" class="form-text  text-success">
                                      Changes:  {{$memberUpdateProfiles->ref_name ?? ''}}
                                    </small>
                                    @endif
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_pa">Reference Mobile</label>
                                    <input type="email" class="form-control" id="app_pa" value="{{$memberUpdateProfiles->member->ref_mobile
                                        ?? ''}}" readonly>
                                    @if(!is_null($memberUpdateProfiles->ref_mobile))
                                    <small id="m_name" class="form-text  text-success">
                                      Changes:  {{$memberUpdateProfiles->ref_mobile ?? ''}}
                                    </small>
                                    @endif
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_pa">Reference Member Id Number </label>
                                    <input type="email" class="form-control" id="app_pa" value="{{$memberUpdateProfiles->member->ref_memeber_id_no
                                        ?? ''}}" readonly>
                                    @if(!is_null($memberUpdateProfiles->ref_memeber_id_no))
                                    <small id="m_name" class="form-text  text-success">
                                      Changes:  {{$memberUpdateProfiles->ref_memeber_id_no ?? ''}}
                                    </small>
                                    @endif
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header text-center">
                        <h3>Nominee’s Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nom_name">Name of Nominee</label>
                                                    <input type="email" class="form-control" id="nom_name" value="{{$memberUpdateProfiles->member->nominee->name
                                                        ?? ''}}" readonly>
                                                       @if(!is_null($memberUpdateProfiles->nominee_name))
                                                       <small id="m_name" class="form-text  text-success">
                                                         Changes:  {{$memberUpdateProfiles->nominee_name ?? ''}}
                                                       </small>
                                                       @endif
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="nom_f_n">Father's Name</label>
                                                    <input type="email" class="form-control" id="nom_f_n" value="{{$memberUpdateProfiles->member->nominee->father_name
                                                        ?? ''}}" readonly>
                                                  @if(!is_null($memberUpdateProfiles->nominee_father_name))
                                                  <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$memberUpdateProfiles->nominee_father_name ?? ''}}
                                                  </small>
                                                  @endif
                                                  </div> <div class="form-group">
                                                    <label for="n_mn">Mother's Name</label>
                                                    <input type="email" class="form-control" id="n_mn" value="{{$memberUpdateProfiles->member->nominee->mother_name
                                                        ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->nominee_mother_name))
                                                    <small id="m_name" class="form-text  text-success">
                                                      Changes:  {{$memberUpdateProfiles->nominee_mother_name ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div> <div class="form-group">
                                                    <label for="n_dob">Date of Birth</label>
                                                    <input type="email" class="form-control" id="n_dob" value="{{$memberUpdateProfiles->member->nominee->birth_date
                                                        ?? ''}}" readonly>
                                                    @if(!is_null($memberUpdateProfiles->nominee_birth_date))
                                                    <small id="m_name" class="form-text  text-success">
                                                      Changes:  {{$memberUpdateProfiles->nominee_birth_date ?? ''}}
                                                    </small>
                                                    @endif
                                                  </div> <div class="form-group">
                                                    <label for="n_gender"> Gender</label>
                                                    <input type="email" class="form-control" id="n_gender" value="{{$memberUpdateProfiles->member->nominee->gender
                                                        ?? ''}}" readonly>
                                                     @if(!is_null($memberUpdateProfiles->nominee_gender))
                                                     <small id="m_name" class="form-text  text-success">
                                                       Changes:  {{$memberUpdateProfiles->nominee_gender ?? ''}}
                                                     </small>
                                                     @endif
                                                  </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="n_mn">Mobile Number</label>
                                                    <input type="email" class="form-control" id="n_mn" value="{{$memberUpdateProfiles->member->nominee->mobile
                                                        ?? ''}}" readonly>
                                                      @if(!is_null($memberUpdateProfiles->nominee_mobile))
                                                      <small id="m_name" class="form-text  text-success">
                                                        Changes:  {{$memberUpdateProfiles->nominee_mobile ?? ''}}
                                                      </small>
                                                      @endif
                                                  </div> <div class="form-group">
                                                    <label for="n_nid">National ID Number</label>
                                                    <input type="email" class="form-control" id="n_nid" value="{{$memberUpdateProfiles->member->nominee->nid
                                                        ?? ''}}" readonly>
                                                      @if(!is_null($memberUpdateProfiles->nominee_nid))
                                                      <small id="m_name" class="form-text  text-success">
                                                        Changes:  {{$memberUpdateProfiles->nominee_nid ?? ''}}
                                                      </small>
                                                      @endif
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="n_rwa">Relationship with Applican</label>
                                                    <input type="email" class="form-control" id="n_rwa" value="{{$memberUpdateProfiles->member->nominee->relation_with_user
                                                        ?? ''}}" readonly>
                                                      @if(!is_null($memberUpdateProfiles->nominee_relation_with_user))
                                                      <small id="m_name" class="form-text  text-success">
                                                        Changes:  {{$memberUpdateProfiles->nominee_relation_with_user ?? ''}}
                                                      </small>
                                                      @endif
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="n_pdt">Professional details</label>
                                                    <input type="email" class="form-control" id="n_pdt" value="{{$memberUpdateProfiles->member->nominee->professional_details
                                                        ?? ''}}" readonly>
                                                      @if(!is_null($memberUpdateProfiles->nominee_professional_details))
                                                      <small id="m_name" class="form-text  text-success">
                                                        Changes:  {{$memberUpdateProfiles->nominee_professional_details ?? ''}}
                                                      </small>
                                                      @endif
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Applicant’s Nominee Image</label>
                                            <a href=""  data-toggle="modal" data-target="#nomiProfileChange">
                                                <img
                                                src="{{!is_null($memberUpdateProfiles->nominee_image) ? $memberUpdateProfiles->nominee_avater_url :  $memberUpdateProfiles->member->nominee->avatar_url  }}"
                                                alt=""
                                                class="img-fluid {{!is_null($memberUpdateProfiles->nominee_image) ? 'image_change' : ''}} "
                                                style="height: 250px; width: 250px"

                                                />
                                            </a>

                                          </div>
                                          @if(!is_null($memberUpdateProfiles->image))
                                            <!-- Modal -->
                                            <div class="modal fade" id="nomiProfileChange" tabindex="-1" aria-labelledby="nomiProfileChangeLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"> Update Applicant’s Nominee Image</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <table>
                                                                <tr class="text-center">
                                                                    <td>OLD</td>
                                                                    <td>NEW</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img
                                                                        src="{{$memberUpdateProfiles->member->nominee->avatar_url  }}"
                                                                        alt=""
                                                                        class="img-fluid {{!is_null($memberUpdateProfiles->nominee_image) ? 'image_change' : ''}} "
                                                                        style="height: 250px; width: 250px"

                                                                        />

                                                                    </td>
                                                                    <td>
                                                                        <img
                                                                        src="{{!is_null($memberUpdateProfiles->nominee_image) ? $memberUpdateProfiles->nominee_avater_url :  $memberUpdateProfiles->member->nominee->avatar_url  }}"
                                                                        alt=""
                                                                        class="img-fluid {{!is_null($memberUpdateProfiles->nominee_image) ? 'image_change' : ''}} "
                                                                        style="height: 250px; width: 250px"

                                                                        />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="user_img"
                                    >NID Front Side
                                </label>

                                <a href=""  data-toggle="modal" data-target="#appNidFront">
                                    <img
                                        src="{{!is_null($memberUpdateProfiles->nominee_nid_front) ? $memberUpdateProfiles->nominee_nid_front_image :  $memberUpdateProfiles->member->nominee->nid_front_image  }}"
                                        alt=""
                                        class="img-fluid {{!is_null($memberUpdateProfiles->nominee_nid_front) ? 'image_change' : ''}} "
                                        style="height: 185px; width: 100%"

                                    />
                                </a>

                                @if(!is_null($memberUpdateProfiles->nominee_nid_front))
                                    <!-- Modal -->
                                <div class="modal fade" id="appNidFront" tabindex="-1" aria-labelledby="appNidFrontLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> Update Front NID Image</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <table>
                                                    <tr class="text-center">
                                                        <td>OLD</td>
                                                        <td>NEW</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <img
                                                                src="{{$memberUpdateProfiles->member->nominee->nid_front_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->nominee_nid_front) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                        <td>
                                                            <img
                                                                src="{{!is_null($memberUpdateProfiles->nominee_nid_front) ? $memberUpdateProfiles->nominee_nid_front_image :  $memberUpdateProfiles->member->nominee->nid_front_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->nominee_nid_front) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="user_img"
                                    >NID Back Side
                                </label>

                                <a href=""  data-toggle="modal" data-target="#appNidFront">
                                    <img
                                        src="{{!is_null($memberUpdateProfiles->nominee_nid_back) ? $memberUpdateProfiles->nominee_nid_back_image :  $memberUpdateProfiles->member->nominee->nid_back_image  }}"
                                        alt=""
                                        class="img-fluid {{!is_null($memberUpdateProfiles->nominee_nid_back) ? 'image_change' : ''}} "
                                        style="height: 185px; width: 100%"

                                    />
                                </a>

                                @if(!is_null($memberUpdateProfiles->nominee_nid_back))
                                    <!-- Modal -->
                                <div class="modal fade" id="appNidFront" tabindex="-1" aria-labelledby="appNidFrontLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> Update Backend NID Image</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <table>
                                                    <tr class="text-center">
                                                        <td>OLD</td>
                                                        <td>NEW</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <img
                                                                src="{{$memberUpdateProfiles->member->nominee->nid_back_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->nominee_nid_back) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                        <td>
                                                            <img
                                                                src="{{!is_null($memberUpdateProfiles->nominee_nid_back) ? $memberUpdateProfiles->nominee_nid_back_image :  $memberUpdateProfiles->member->nominee->nid_back_image  }}"
                                                                alt=""
                                                                class="img-fluid {{!is_null($memberUpdateProfiles->nominee_nid_back) ? 'image_change' : ''}} "
                                                                style="height: 185px; width: 100%"

                                                            />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header text-center">
                        <h3>Member Choice</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="19%"></th>
                                            <th scope="col" width="27%">
                                                Project-1 <br />
                                                Areas in Dhaka City Corporation
                                            </th>
                                            <th scope="col" width="27%">
                                                Project-2
                                                <br />
                                                Areas close to Dhaka City
                                                Corporation
                                            </th>
                                            <th scope="col" width="27%">
                                                Project-3 <br />Other District
                                                Except Dhaka
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Prefered Area:</th>
                                            <td>
                                                @php
                                                    $old_pref_area = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';
                                                    $update_pref_area = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_of_dhaka_city')->first(): '';
                                                    $old_aodc_pref_area_string = '';
                                                    if(!is_null($old_pref_area) && count($old_pref_area->prefered_area)){

                                                        foreach($old_pref_area->prefered_area as $preference){
                                                            $old_aodc_pref_area_string .= $preference['value'].', ';
                                                        }
                                                    }
                                                    $udt_area_of_dcc_pref_area_str = '';
                                                    if(!is_null($update_pref_area) && count($update_pref_area->prefered_area)){

                                                        foreach($update_pref_area->prefered_area as $preference){

                                                            $udt_area_of_dcc_pref_area_str .= $preference['value'].', ';
                                                        }
                                                    }

                                                @endphp

                                                <input type="text" class="form-control" value="{{$old_aodc_pref_area_string}}" readonly disabled>

                                                @if(!is_null($update_pref_area) && is_null($old_pref_area)  && count($update_pref_area->prefered_area)> 0)
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$udt_area_of_dcc_pref_area_str}}
                                                  </small>
                                                @elseif(!is_null($update_pref_area) && !is_null($old_pref_area) && (count($old_pref_area->prefered_area) != count($update_pref_area->prefered_area)) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$udt_area_of_dcc_pref_area_str}}
                                                  </small>
                                                  @endif
                                            </td>
                                            <td>
                                                @php
                                                    $old_pref_area = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';
                                                    $update_pref_area = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_close_to_dhaka_city')->first(): '';
                                                    $old_area_clos_dcc_pref_area_string = '';
                                                    if(!is_null($old_pref_area) && count($old_pref_area->prefered_area)){

                                                        foreach($old_pref_area->prefered_area as $preference){
                                                            $old_area_clos_dcc_pref_area_string .= $preference['value'].', ';
                                                        }
                                                    }
                                                    $udt_area_clos_to_dcc_pref_area_str = '';
                                                    if(!is_null($update_pref_area) && count($update_pref_area->prefered_area)){

                                                        foreach($update_pref_area->prefered_area as $preference){

                                                            $udt_area_clos_to_dcc_pref_area_str .= $preference['value'].', ';
                                                        }
                                                    }

                                                @endphp

                                                <input type="text" class="form-control" value="{{$old_area_clos_dcc_pref_area_string}}" readonly disabled>

                                                @if(!is_null($update_pref_area) && is_null($old_pref_area)  && count($update_pref_area->prefered_area)> 0)
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$udt_area_clos_to_dcc_pref_area_str}}
                                                  </small>
                                                @elseif(!is_null($update_pref_area) && !is_null($old_pref_area) && (count($old_pref_area->prefered_area) != count($update_pref_area->prefered_area)) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$udt_area_clos_to_dcc_pref_area_str}}
                                                  </small>
                                                  @endif
                                            </td>
                                            <td>
                                                @php
                                                      $old_pref_area = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';
                                                    $update_pref_area = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','other_distict')->first(): '';
                                                    $old_other_dis_pref_area_string = '';
                                                    if(!is_null($old_pref_area) && count($old_pref_area->prefered_area)){

                                                        foreach($old_pref_area->prefered_area as $preference){
                                                            $old_other_dis_pref_area_string .= $preference['value'].', ';
                                                        }
                                                    }
                                                    $udt_other_dis_pref_area_str = '';
                                                    if(!is_null($update_pref_area) && count($update_pref_area->prefered_area)){

                                                        foreach($update_pref_area->prefered_area as $preference){

                                                            $udt_other_dis_pref_area_str .= $preference['value'].', ';
                                                        }
                                                    }

                                                @endphp

                                                <input type="text" class="form-control" value="{{$old_other_dis_pref_area_string}}" readonly disabled>

                                                @if(!is_null($update_pref_area) && is_null($old_pref_area)  && count($update_pref_area->prefered_area)> 0)
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$udt_other_dis_pref_area_str}}
                                                  </small>
                                                @elseif(!is_null($update_pref_area) && !is_null($old_pref_area) && (count($old_pref_area->prefered_area) != count($update_pref_area->prefered_area)) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$udt_other_dis_pref_area_str}}
                                                  </small>
                                                  @endif
                                            </td>
                                        </tr>

                                        <tr>

                                            <td scope="row">
                                                Capacity Range (Tk.)
                                            </td>
                                            <td>
                                                @php
                                                    $old_pref_area = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';
                                                    $update_pref_area = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_of_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_pref_area) ? $old_pref_area->capacity_range : ""}}" disabled readonly>
                                                @if(is_null($old_pref_area) && !is_null($update_pref_area))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_pref_area->capacity_range ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_pref_area) && !is_null($update_pref_area) && ($old_pref_area->capacity_range != $update_pref_area->capacity_range) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_pref_area->capacity_range ?? ''}}
                                                  </small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_close_to_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->capacity_range : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->capacity_range ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->capacity_range != $update_member_choice->capacity_range) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->capacity_range ?? ''}}
                                                  </small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','other_distict')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->capacity_range : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->capacity_range ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->capacity_range != $update_member_choice->capacity_range) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->capacity_range ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td scope="row">
                                                Prefered Flat Size(Net)
                                            </td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_of_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->flat_size ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->flat_size != $update_member_choice->flat_size) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->flat_size ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_close_to_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->flat_size ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->flat_size != $update_member_choice->flat_size) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->flat_size ?? ''}}
                                                  </small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','other_distict')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->flat_size ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->flat_size != $update_member_choice->flat_size) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->flat_size ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td scope="row">Expected Bank Loan</td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_of_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->exp_bank_loan ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->exp_bank_loan != $update_member_choice->exp_bank_loan) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->exp_bank_loan ?? ''}}
                                                  </small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_close_to_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->exp_bank_loan ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->exp_bank_loan != $update_member_choice->exp_bank_loan) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->exp_bank_loan ?? ''}}
                                                  </small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','other_distict')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->exp_bank_loan ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->exp_bank_loan != $update_member_choice->exp_bank_loan) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->exp_bank_loan ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td scope="row">
                                                Number of Flat Share:
                                            </td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_of_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->num_flat_shares ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->num_flat_shares != $update_member_choice->num_flat_shares) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->num_flat_shares ?? ''}}
                                                  </small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_close_to_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->num_flat_shares ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->num_flat_shares != $update_member_choice->num_flat_shares) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->num_flat_shares ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','other_distict')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->num_flat_shares ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->num_flat_shares != $update_member_choice->num_flat_shares) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->num_flat_shares ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                Project introducer Name
                                            </td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_of_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->p_introducer_name : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_name ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->p_introducer_name != $update_member_choice->p_introducer_name) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_name ?? ''}}
                                                  </small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_close_to_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->p_introducer_name : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_name ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->p_introducer_name != $update_member_choice->p_introducer_name) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_name ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','other_distict')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->p_introducer_name : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_name ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->p_introducer_name != $update_member_choice->p_introducer_name) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_name ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td scope="row">
                                                Project introducer Member Id
                                            </td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_of_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->p_introducer_member_num : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_member_num ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->p_introducer_member_num != $update_member_choice->p_introducer_member_num) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_member_num ?? ''}}
                                                  </small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_close_to_dhaka_city')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->p_introducer_member_num : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_member_num ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->p_introducer_member_num != $update_member_choice->p_introducer_member_num) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_member_num ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';
                                                    $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','other_distict')->first(): '';
                                                @endphp
                                                <input type="text" class="form-control" value="{{!is_null($old_member_choice) ? $old_member_choice->p_introducer_member_num : ""}}" disabled readonly>

                                                @if(is_null($old_member_choice) && !is_null($update_member_choice))
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_member_num ?? ''}}
                                                  </small>
                                                @elseif(!is_null($old_member_choice) && !is_null($update_member_choice) && ($old_member_choice->p_introducer_member_num != $update_member_choice->p_introducer_member_num) )
                                                <small id="m_name" class="form-text  text-success">
                                                    Changes:  {{$update_member_choice->p_introducer_member_num ?? ''}}
                                                  </small>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <form action="{{route('admin.updated.profiles.submit')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$memberUpdateProfiles->id}}">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Status</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="status" required>
                         @foreach ($all_status as $status )
                             <option value="{{$status}}"{{ $status == \App\Models\MemberProfileUpdate::STATUS_APPROVE ? 'selected':'' }}>{{ucfirst($status)}}</option>
                         @endforeach
                        </select>
                      </div>
                    <div class="text-left my-3">
                        <button type="submit" class="btn btn-success">
                            Submit
                        </button>
                    </div>
                </form>




            </div>
        </div>
    </div>
</div>


@endsection

@push('style')

@endpush
@push('script')

@endpush
