<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <img src = "Images/Logo.png" alt = "logo" height = "75px" width = "230px" />

    <span class="right_header"
        style = "float:right;height:70px;width:200px;text-align:right;font-family:Sans-serif;font-size:13px;">

        <p><strong>Professional Schools</strong></br>
            <i> Ground Floor, PS Building</br>
                Matina Campus, Davao City</br>
                Telefax: (082) 305-0640 local 189</i>

        </p>
    </span>
    </div>
    <div id="mid">
        <div class="info">
            <hr style = "width:100%;text-align:left;background-color:red;">
            <div id = "currentdate">Date: <strong>{{\Carbon\Carbon::now()->format('F d, Y')}}<strong></div><br><br>
            </hr>
            <br>

            <div id="table3" style = "font-size:12px;font-family:Sans-serif;">
        
           
                <table>
                    <thead>
                        <tr id="Studentheader">
                            <td id="student"><strong>Student's Name</strong></td>
                            <td id="adviser"><strong>Adviser</strong></td>
                            <td id="degree"><strong>Degree</strong></td>
                            <td id="amount"><strong>Amount</strong></td>
                            <td id="reference"><strong>Reference Number</strong></td>
                            <td id="date"><strong>Date Issued</strong></td>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($receipts as $data)

                        <tr id = "Studentdata">
                            <td id = "stud">{{ $data->user->name }}</td>
                            <td id = "adv">{{ $data->researchPaper->adviser->name }}</td>
                            <td>{{ $data->user->degree_type }}</td>
                            <td>{{ $data->amount }}.00</td>
                            <td>{{ $data->reference_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('M d, Y')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
</div>
</div>
</div>

<style>
#Studentheader {
    background-color: #78c0c4;
    border: white solid 1rem;
    text-align: center;
}
#Studentdata {
    text-align:center; 
}
#date {
width:100px;
}
#degree {
    width:75px;
    text-align:center;
}
#blank1, #blank2 {
    width: 12px;
}
#adviser, #student, #blank3{ 
    width: 150px;
}
#payment {
    width: 350px;
}
#amount, #paymentamount {
    width:95px;
    text-align:center;
}
#reference {
    width: 110px;
}
#stud, #adv{
    text-align:left; 
}
#currentdate{
    float:left;
    width:160px;
    height:10px;
    font-family:Sans-serif;
    text-align:left;
    font-size:12px;
}

</style>
<br>
<div id ="Total2" style = "border: 1px solid black;font-size:12px;font-family:Sans-serif;background-color:gray;
    ">
        <strong>
            <table>
                <tr id="Totalpayment">
                    <td id = "payment">Total Payment Made by Students for <strong>{{$stage}}</strong></td>
                    <td id = "blank1"></td>
                    <td id = "blank2"></td>
                    <td id = "paymentamount"><strong>{{ $totalAmount }}.00</strong></td>
                    <td id = "blank3"></td>
                    <!--amount should be displayed here-->
                </tr>
                </table>
        </strong>
    </div>



            <p style = "font-size:10px;font-family:Sans-serif;"><i>*Please see attached receipts. Thank you*</i></p>
<!--
            <div id="footer"
                style = "clear:both;position:absolute;bottom:50px;width:1250px;font-family:Sans-serif;font-size:13px;text-align:left;">

                <table>
                    <tr class="tabletitle">
                        <td class="adviser" align = "left" style = "width:150px;">Prepared by:</td>
                        <td class="currency" align = "right" style = "width:215px;">Recommending Approval:</td>
                        <td class="aamount" align = "right" style = "width:120px;">Noted by:</td>
                    </tr>
                </table>
                <br>

                <strong>
                    <table>
                        <tr class="tabletitle" style = "text-align:left;">
                            <td class="adviser" align = "left" style = "width:150px;">ARNIEMEE V. NUDALO</td>
                            <td class="currency" align = "right" style = "width:247px;">MA. LINDA B. ARQUIZA, EdD</td>
                            <td class="aamount" align = "right" style = "width:213px;">EUGENIO S. GUHAO JR., DM</td>
                        </tr>
                    </table>
                </strong>
                <table>
                    <tr class="tabletitle" style = "text-align:left;font-size:12px;">
                        <td class="adviser" align = "left" style = "width:200px;">Research Administrative Assistant</td>
                        <td class="currency" align = "right" style = "width:100px;">Assistant Dean</td>
                        <td class="aamount" align = "right" style = "width:160px;">Dean</td>
                    </tr>
                </table>

            </div>
-->
</body>

</html>
