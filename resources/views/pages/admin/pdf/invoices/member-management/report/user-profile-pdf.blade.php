<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
         table{
            width: 100%;
        }
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
         .membership_number table  tr td{
                width: 20%;

            }
            .result{
                clear: both;;
            }
            .result_left{
                float: left;
            }
            .result_right{
                float: right;
            }

            .inner_table tr, .inner_table tr td, .inner_table table{
                border: none;
            }
            .header_section{
                text-align: center;
            }
            .header_section h1, .header_section h2,.header_section p{
                margin: 6px 0;
            }

            .member_choice_section table{
            width: 100%;
        }

          .member_choice_section  tr td{
                width: 20%;

            }
    </style>
</head>
<body>
   <div class="container">

        <div class="header_section">
            <h1>
               <strong> {{ !is_null(getSetting('name')) ? getSetting('name') : 'Cadre Officers’ Co-operative Society Limited (COCSOL)' }} </strong>
            </h1>
            <p>E-mail: {{  !is_null(getSetting('email')) ? getSetting('email') : 'cocsol2022@gmail.com' }} </p>
            <h2> {{ !is_null( getSetting('address')) ?  getSetting('address') : 'House no-738, Flat-2/B, Ibrahimpur, P.O. Kafrul' }}  </h2>
            {{-- <h2>P.S. Dhaka Cantonment, Dhaka</h2> --}}
        </div>

        <h2 style="    text-align: center;"><u>Membership Application</u></h2>
        <div class="membership_number">
            <table>

                    <tr>
                        <td colspan="2">COCSOL Membership Number (Office use only)</td>
                        <td colspan="2">
                            {{ optional($member->associatorsInfo)->membershp_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Date of approval</td>
                        <td>  {{ optional($member->associatorsInfo)->approval_date ?? '' }}</td>
                        <td>Number of share/s
                        </td>
                        <td>  {{ optional($member->associatorsInfo)->num_or_shares ?? '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center">
                            <h3>Applicant’s Information with Photograph</h3>
                        </td>
                    </tr>

            </table>

        </div>
        <div class="applicent_details">
            <table>
                <tr>
                    <td style="    width: 20%;">Name of Applicant</td>
                    <td style="    width: 65%;">{{$member->name}}</td>
                    <td rowspan="5" style="text-align: center">
                       {{-- <img src="{{getImage(\App\Models\Member::APPLICENT_IMAGE.'/'.$member->image)}}" alt="" style="width: 120px;height: 120px;border:1px solid #000;" class="img-fluid"> --}}


                       <img src="{{ public_path("storage/".\App\Models\Member::APPLICENT_IMAGE.'/'.$member->image) }}" style="width: 120px;height: 120px;border:1px solid #000;" class="img-fluid">
                    </td>
                </tr>
                <tr>
                    <td style="    width: 20%;">Father’s Name</td>
                    <td style="    width: 65%;">{{$member->father_name ?? ''}}</td>

                </tr>
                <tr>
                    <td style="    width: 20%;">Mother’s Name</td>
                    <td style="    width: 65%;">
                        {{$member->mother_name ?? ''}}
                    </td>

                </tr>

                <tr>
                    <td style="    width: 20%;">Name of Spouse
                    </td>
                    <td style="    width: 65%;">
                        {{$member->spouse_name ?? ''}}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">BCS Batch & Cadre
                    </td>

                    <td style="    width: 65%;">  {{$member->bcs_batch ?? ''}}</td>


                </tr>
                <tr>
                    <td style="    width: 20%;">Joining Date
                    </td>

                    <td style="    width: 65%;">
                       <div class="inner_table">
                        <table>
                            <tr>
                                <td>{{ $member->joining_date }}</td>
                                <td style="    text-align: right;"> Cadre ID</td>
                            </tr>
                        </table>
                       </div>

                    </td>
                    <td >
                        {{ $member->cader_id ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="    width: 20%;">Date of Birth
                    </td>

                    <td style="    width: 65%;">
                       <div class="inner_table">
                        <table>
                            <tr>
                                <td>{{ $member->birth_date ?? '' }}</td>
                                <td style="    text-align: right;"> Gender</td>
                            </tr>
                        </table>
                       </div>

                    </td>
                    <td >
                        {{ $member->gender ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="    width: 20%;">Mobile Number
                    </td>

                    <td colspan="2">
                        {{ $member->mobile ?? '' }}

                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">Email Address
                    </td>

                    <td colspan="2">

                        {{ $member->email ?? '' }}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">Designation &
                        Office Address
                    </td>

                    <td colspan="2">
                        {{ $member->office_address ?? '' }}

                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">National ID Number
                    </td>

                    <td colspan="2">

                        {{ $member->nid ?? '' }}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">Present Address
                    </td>

                    <td colspan="2">

                        {{ $member->present_address ?? '' }}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">Permanent Address
                    </td>

                    <td colspan="2">

                        {{ $member->permanent_address ?? '' }}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">Emergency Contact
                    </td>

                    <td colspan="2">
                        {{ $member->emergency_contact ?? '' }}

                    </td>

                </tr>

            </table>
            <br>
            <br>
            <table>
                <tr>
                    <td colspan="2" style="text-align: center">
                        <h3>Nominee’s Information with Photograph</h3>
                    </td>

                    <td rowspan="4" style="width: 15%;text-align: center"  >
{{--
                         <img src="{{getImage(\App\Models\Member::APPLICENT_IMAGE.'/'.$member->nominee->image)}}" alt="" style="width: 120px;height: 120px;border:1px solid #000;" class="img-fluid"> --}}
                         <img src="{{public_path('storage/'.\App\Models\Nominee::NOMINEE_IMAGE.'/'.$member->nominee->image)}}" alt="" style="width: 120px;height: 120px;border:1px solid #000;" class="img-fluid">


                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">
                        Name of Nominee
                    </td>

                    <td >
                        {{ optional($member->nominee)->name ?? '' }}

                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">
                        Father’s Name
                    </td>

                    <td >

                        {{ optional($member->nominee)->father_name ?? '' }}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">
                        Mother’s Name
                    </td>

                    <td >
                        {{ optional($member->nominee)->mother_name ?? '' }}

                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">Date of Birth
                    </td>

                    <td style="    width: 65%;">
                       <div class="inner_table">
                        <table>
                            <tr>
                                <td>   {{ optional($member->nominee)->birth_date ?? '' }}</td>
                                <td style="    text-align: right;">Gender</td>
                            </tr>
                        </table>
                       </div>

                    </td>
                    <td >
                        {{ optional($member->nominee)->gender ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="    width: 20%;">
                        Mobile Number
                    </td>

                    <td colspan="2">

                        {{ optional($member->nominee)->mobile ?? '' }}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">
                        Relationship with
                        Applicant
                    </td>

                    <td colspan="2">
                        {{ optional($member->nominee)->relation_with_user ?? '' }}

                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">
                        National ID Number
                    </td>

                    <td colspan="2">

                        {{ optional($member->nominee)->nid ?? '' }}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">
                        Professional details

                    </td>

                    <td colspan="2">

                        {{ optional($member->nominee)->professional_details ?? '' }}
                    </td>

                </tr>
                <tr>
                    <td style="    width: 20%;">
                        Permanent Address


                    </td>

                    <td colspan="2">
                        {{ optional($member->nominee)->permanent_address ?? '' }}

                    </td>

                </tr>


            </table>

        </div>

        <div class="member_choice_section">
            <table>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center">
                            <h3>Member Choice</h3>
                        </td>
                    </tr>

                </tbody>
            </table>
            <table >
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
                        <td >Prefered Area:</td>
                        <td>
                            @php
                                $old_pref_area = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';

                                $old_aodc_pref_area_string = '';
                                if(!is_null($old_pref_area) && count($old_pref_area->prefered_area)){

                                    foreach($old_pref_area->prefered_area as $preference){
                                        $old_aodc_pref_area_string .= $preference['value'].', ';
                                    }
                                }


                            @endphp

                            {{$old_aodc_pref_area_string}}

                        </td>
                        <td>
                            @php
                                $old_pref_area = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';

                                $old_area_clos_dcc_pref_area_string = '';
                                if(!is_null($old_pref_area) && count($old_pref_area->prefered_area)){

                                    foreach($old_pref_area->prefered_area as $preference){
                                        $old_area_clos_dcc_pref_area_string .= $preference['value'].', ';
                                    }
                                }


                            @endphp

                            {{$old_area_clos_dcc_pref_area_string}}


                        </td>
                        <td>
                            @php
                                  $old_pref_area = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';

                                $old_other_dis_pref_area_string = '';
                                if(!is_null($old_pref_area) && count($old_pref_area->prefered_area)){

                                    foreach($old_pref_area->prefered_area as $preference){
                                        $old_other_dis_pref_area_string .= $preference['value'].', ';
                                    }
                                }

                            @endphp

                            {{$old_other_dis_pref_area_string}}

                        </td>
                    </tr>

                    <tr>

                        <td scope="row">
                            Capacity Range (Tk.)
                        </td>
                        <td>
                            @php
                                $old_pref_area = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_pref_area) ? $old_pref_area->capacity_range : ""}}
                        </td>

                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';

                            @endphp
                          {{!is_null($old_member_choice) ? $old_member_choice->capacity_range : ""}}
                        </td>

                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->capacity_range : ""}}
                        </td>
                    </tr>

                    <tr>
                        <td scope="row">
                            Prefered Flat Size(Net)
                        </td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';

                            @endphp
                            {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>

                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';
                                $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','other_distict')->first(): '';
                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>
                    </tr>

                    <tr>
                        <td scope="row">Expected Bank Loan</td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>

                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>

                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';

                            @endphp
                            {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>
                    </tr>

                    <tr>
                        <td scope="row">
                            Number of Flat Share:
                        </td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>

                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';
                                $update_member_choice = !is_null($member->memberChoicesUpdate) ? $member->memberChoicesUpdate->where('project_type','area_close_to_dhaka_city')->first(): '';
                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';

                            @endphp
                          {{!is_null($old_member_choice) ? $old_member_choice->flat_size : ""}}
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            Project introducer Name:
                        </td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->p_introducer_name : ""}}
                        </td>

                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->p_introducer_name : ""}}
                        </td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';

                            @endphp
                          {{!is_null($old_member_choice) ? $old_member_choice->p_introducer_name : ""}}
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            Project introducer Member Id:
                        </td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_of_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->p_introducer_member_num : ""}}
                        </td>

                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','area_close_to_dhaka_city')->first() : '';

                            @endphp
                           {{!is_null($old_member_choice) ? $old_member_choice->p_introducer_member_num : ""}}
                        </td>
                        <td>
                            @php
                                $old_member_choice = !is_null($member->memberChoices) ? $member->memberChoices->where('project_type','other_distict')->first() : '';

                            @endphp
                          {{!is_null($old_member_choice) ? $old_member_choice->p_introducer_member_num : ""}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>



   </div>
</body>
</html>
