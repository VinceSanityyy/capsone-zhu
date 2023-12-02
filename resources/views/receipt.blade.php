<!DOCTYPE html>
<div id="header">
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
        <hr style = "width:100%;background-color:red;"></hr>
        <div id = "currentdate">Date: <strong>{{\Carbon\Carbon::now()->format('F d, Y')}}<strong></div>

       

        <p style = "font-size:12px;font-family:Sans-serif;">TO
            <span style = "margin: right 20px;">:<strong> Accounting Department</strong></span></p>
            <p style = "font-size:12px;font-family:Sans-serif;">FROM
            <span style = "margin: right 2px;">:<strong> Professional Schools</strong></span></p>
            <p style = "font-size:12px;font-family:Sans-serif;">RE
            <span style = "margin: right 20px;">:<strong> Payment of Final Adviser's Fee</strong></span>
        </p>

        <hr style = "width:100%;text-align:left;background-color:red;">
        </hr>
        
    </div>

   
</div>

<div id="bot">
    <p style = "font-size:13px;font-family:Sans-serif;text-align:justify;">
        Please release thru check to the following their corresponding payment for the services rendered
        as adviser (Final Adviser's fee) of the following students:
    </p>
    <br>


    <div id="table" style = "font-size:12px;font-family:Sans-serif;">
        
            <table>
                <thead>
                    <tr id="Adviserheader">
                        <td id="tdadviser"><strong>Adviser</strong></td>
                        <td id="tdcurrency"><strong>Currency</strong></td>
                        <td id="tdamount"><strong>Amount</strong></td>
                    </tr>
                </thead>

                <tbody>
                    @foreach($advisers as $data)
                    <tr id = "Adviserdata">
                        <td id = "adv">{{ $data['name'] }}</td> 
                        <td>Php</td> 
                        <td>{{ $data['amount'] }}.00</td> 
                    </tr>
                    @endforeach
                </tbody>
            </table>
</div><br>

<div id ="Total1" style = " border: 1px solid black;font-size:12px;font-family:Sans-serif;background-color:gray;">
        <strong>
            <table>
                <thead>
                    <tr id="Total">
                        <td id="totalreq">Total Amount Requested</td>
                        <td id="pesos">Php</td>
                        <td id="totalamount">{{$adviserTotalAmount}}.00</td>
                        <!--amount should be displayed here-->
                    </tr>
                </thead>
            </table>
        </strong>
    </div>

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

                        @foreach($students as $data)

                        <tr id = "Studentdata">
                            <td id = "stud">{{ $data->user->name }}</td>
                            <td id = "adv">{{ $data->researchPaper->adviser->name }}</td>
                            <td>{{ $data->user->degree_type }}</td>
                            <td>{{ $data->amount }}.00</td>
                            <td>{{ $data->reference_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->date_submitted)->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>

<br>
<div id ="Total2" style = "border: 1px solid black;font-size:12px;font-family:Sans-serif;background-color:gray;
    ">
        <strong>
            <table>
                <tr id="Totalpayment">
                    <td id = "payment">Total Payment Made by Students</td>
                    <td id = "blank1"></td>
                    <td id = "blank2"></td>
                    <td id = "paymentamount">{{ $studentTotalAmount }}.00</td>
                    <td id = "blank3"></td>
                    <!--amount should be displayed here-->
                </tr>
                </table>
        </strong>
    </div>

<style>

#Adviserheader, #Studentheader {
    background-color: #78c0c4;
    border: white solid 1rem;
    text-align: center;
}
#tdadviser, #tdcurrency, #tdamount {
    width:230px;
    text-align:center;
}
#Adviserdata, #Studentdata{
    text-align:center; 
}
#stud, #adv{
    text-align:left; 
}
#pesos, #totalamount {
    width:230px;
    text-align:center; 
}
#totalreq{
    text-align:left;
    width:230px;
}
#degree, #amount, #paymentamount {
    width:75px;
    text-align:center;
}
#date {
    width:100px;
}
#adviser, #student, #blank3{ 
    width: 150px;
}
#payment{
    width: 350px;
}
#blank1, #blank2{ 
    width: 12px;
}
#reference {
    width: 130px;
}
#PB, #Signature1, #Role1 {
    width: 180px;
    text-align:left;
}
#RA, #Signature2, #Role2 {
    width: 210px;
    text-align:left;
}
#NB, #Signature3, #Role3{
    width: 180px;
    text-align:left;
}
#currentdate{
    float:right;
    width:145px;
    height:10px;
    font-family:Sans-serif;
    text-align:right;
    font-size:12px;
}
#footer{
clear:both;
bottom:20px;
font-family:Sans-serif;
font-size:13px;
text-align:left;
page-break-before:avoid;
position:fixed;
}
</style>

<p style = "font-size:10px;font-family:Sans-serif;"><i>*Please see attached receipts. Thank you*</i></p>

<div id="footer">
        <table>
            <tr class="Table6">
                <td id ="PB">Prepared by:</td>
                <td id ="RA">Recommending Approval:</td>
                <td id ="NB">Noted by:</td>
            </tr>
        </table>
        <br>

        <strong>
            <table>
                <tr class="Table7">
                    <td id="Signature1">ARNIEMEE V. NUDALO</td>
                    <td id="Signature2">MA. LINDA B. ARQUIZA, EdD</td>
                    <td id="Signature3">EUGENIO S. GUHAO JR., DM</td>
                </tr>
            </table>
        </strong>
        <table>
            <tr class="Table8">
                <td id="Role1">Research Administrative Assistant</td>
                <td id="Role2">Assistant Dean</td>
                <td id="Role3">Dean</td>
            </tr>
        </table>
</div>
