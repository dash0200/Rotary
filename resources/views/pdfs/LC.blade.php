<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LC</title>

    <style>
        body {
            border: 1px solid black;            
        }

        .fb {
            font-weight: bold;
        }

        .bb {
            border-bottom: 1px solid black;
        }

        td {
            padding-bottom: 0.1rem;
            padding-top: 0.1rem;
        }
    </style>

</head>
<body>
    
    <table style="width: 100%;" class="bb">
        <tr>
            <td align="center">
                <div style="font-size: 14px;" class="fb">NAVANAGAR ROTARY EDUCATION SOCIETY'S</div>
                <div class="fb"> NAVANAGAR ROTARY ENGLISH MEDIUM SCHOOL </div>
                <div style="font-size: 12px; margin-top: 0.3rem;" class="fb" > NAVANAGAR, HUBBALLI-580025 </div>
                <div style="font-size: 13px;" class="fb"> (Recognized by Government of Karnataka) </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%;" class="bb">
        <tr>
            <td align="center">
                <div style="font-size: 22px; font-weight: bold;">LEAVING CERTIFICATE</div>

                <div style="font-size: 13px;">
                    <div>No changes whatsoever may be made in the Certificate except by the issuing authority.</div>
                    <div>Any default against this rule is liable to be punished.</div>
                </div>
            </td>
        </tr>

        <tr>
            <td align="center" style="font-size: 13px;">

            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 1. Register Number </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
                <table style="width: 100%;">
                    <tr>
                        <td class="bb">{{$lc->id}}</td>
                        <td align="center"><span class="fb" style="margin-right: 2rem;">2. Date of Admission:</span> <span class="bb">{{date ( 'd-m-Y' , strtotime ( $lc->student->date_of_adm ) )}}</span> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 3. Name of the Pupil </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
              {{strtoupper($lc->student->name)}}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 4. Father's Name </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
                {{strtoupper($lc->student->fname)}}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 5. Mother's Name  </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
                {{strtoupper($lc->student->mname)}}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 6. Surname  </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
                {{strtoupper($lc->student->lname)}}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 7. Gender </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
                <table style="width: 100%;">
                    <tr>
                        <td class="bb">
                            @if($lc->student->gender == 1) 
                                MALE
                            @else
                                FEMALE
                            @endif
                        </td>
                        <td align="center"><span class="fb" style="margin-right: 2rem;">8. Nationality: </span> <span class="bb"> {{$lc->student->nationality}} </span> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 9. Religion </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
                {{strtoupper($lc->student->religion)}}
            </td>
        </tr>
    </table>


    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 10. Caste </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
                {{strtoupper($lc->caste->name)}}
            </td>
        </tr>
    </table>


    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 11. Subcaste </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
                @if($lc->subCaste !== null)
                   {{strtoupper($lc->subCaste->name)}}
                @else
                    -
                @endif
            </td>
        </tr>
    </table>


    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 40%;">
                <span class="fb"> 12. Date of Birth (in figure) </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
               <u> {{$lc->student->dob->format("d-m-Y")}} </u>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 40%;">
                <span class="fb"> 13. Date of Birth (in words) </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
               <u>
                {{strtoupper($lc->dobWord)}}
               </u>
            </td>
        </tr>
    </table>


    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 30%;">
                <span class="fb"> 14. Place of Birth </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
                <table style="width: 100%;">
                    <tr>
                        <td class="bb"> {{strtoupper($lc->student->birth_place)}} </td>
                        <td align="center">
                            <span class="fb" style="margin-right: 2rem;">15. District: </span>
                            <span class="bb"> {{strtoupper($lc->student->subDistrict->name)}}</span> 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 65%;">
                <span class="fb"> 16. Standard in which pupil was studying while leaving the School </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
                {{$lc->student->classes->name." STANDARD SINCE ".strtoupper($lc->student->date_of_adm->format("F ")).$lc->student->date_of_adm->format("Y")}}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 40%;">
                <span class="fb"> 17. Medium of Instruction </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
               <u> ENGLISH </u>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 70%;">
                <span class="fb"> 18. Whether Qualified for Promotion </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
                {{$lc->whether_qualified}}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 50%;">
                <span class="fb"> 19. Date of Pupil's last attendance to this School </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 50%;">
               <u> {{date ( 'd-m-Y' , strtotime ( $lc->lt ) )}} </u>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width:50%;">
                <span class="fb"> 20. Date of Application for Leaving Certificate </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 50%">
               <u> {{date ( 'd-m-Y' , strtotime ( $lc->doa ) )}} </u>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 40%;">
                <span class="fb"> 21. Conduct of Pupil </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
               <u> GOOD </u>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;" class="bb">
        <tr>
            <td align="left" style="width: 60%;">
                <span class="fb"> 22. Reason for Leaving the School </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;" class="bb">
              {{$lc->reason}}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 0.2rem;" class="bb">
        <tr>
            <td align="center" style="font-weight: bold; font-size: 15px;">
                Certified that the person above Information is in accordance with the School General Register.
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding-left: 0.5rem; margin-top: 0.5rem;">
        <tr>
            <td align="left" style="width: 60%; margin: 1rem;">
                <span class="fb"> STS NO </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
              {{strtoupper($lc->student->sts)}}
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 60%;">
                <span class="fb"> DISE CODE </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
              29090210106
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 60%;">
                <span class="fb"> Date </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
              {{date("d/m/Y H:i:s")}}
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 60%;">
                <span class="fb"> Place </span>
            </td>

            <td class="fb">:</td>

            <td align="left" style="width: 100%;">
              NAVANAGAR, HUBBALLI, KARNATAKA
            </td>
        </tr>
    </table>

</body>
</html>