<!DOCTYPE html>
<div id="header">
    <img src = "Images/Logo.jpg" alt = "logo" height = "75px" width = "230px" />

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
        </hr>

        <p style = "font-size:12px;font-family:Sans-serif;">TO
            <span style = "margin: right 20px;">:<strong> Accounting Department</strong></span></p>
            <p style = "font-size:12px;font-family:Sans-serif;">FROM
            <span style = "margin: right 2px;">:<strong> Professional Schools</strong></span></p>
            <p style = "font-size:12px;font-family:Sans-serif;">RE
            <span style = "margin: right 20px;">:<strong> Payment of Final Adviser's Fee</strong></span></p>

        <hr style = "width:100%;text-align:left;background-color:red;">
        </hr>
    </div>
</div>

<div id="bot">
    <p style = "font-size:13px;font-family:Sans-serif;">
        Please release thru check to the following their corresponding payment for the services rendered
        as adviser (Final Adviser's fee) of the following students:
    </p>
    <br>


    <div id="table" style = "font-size:12px;font-family:Sans-serif;">
        <strong>
            <table>
                <thead>
                    <tr class="tabletitle">
                        <td class="adviser" align = "left" style = "width:200px; text-align:center">Adviser</td>
                        <td class="currency" align = "right" style = "width:200px; text-align:center">Currency</td>
                        <td class="aamount" align = "right" style = "width:200px; text-align:center">Amount</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($advisers as $data)
                    <tr>
                        <td class="student" align = "left" style = "width:150px; text-align:center">{{ $data['name'] }}</td> 
                        <td class="student" align = "left" style = "width:150px; text-align:center">PHP</td> 
                        <td class="student" align = "left" style = "width:150px; text-align:center">{{ $data['amount'] }}</td> 
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </strong>
    </div>

    <br>


    <div id ="table2" style = " border: 1px solid black;font-size:12px;font-family:Sans-serif;">
        <strong>
            <table>
                <thead>
                    <tr class="tabletitle">
                        <td class="total" align = "left" style = "width:200px;">Total Amount Requested</td>
                        <td class="adviser" align = "right" style = "width:200px;">{{$adviserTotalAmount}}</td>
                        <!--amount should be displayed here-->
                    </tr>
                </thead>
            </table>
        </strong>
    </div>

    <br>


    <div id="table3" style = "font-size:12px;font-family:Sans-serif;">
        <strong>
            <u>
                <table>
                    <thead>
                        <tr class="tabletitle">
                            <td class="student" align = "left" style = "width:150px">Student's Name</td>
                            <td class="adviser" align = "left" style = "width:150px;">Adviser</td>
                            <td class="degree" align = "left" style = "width:150px;">Degree Type</td>
                            <td class="amount" align = "left" style = "width:120px;">Amount</td>
                            <td class="reference" align = "left" style = "width:120px;">Reference Number</td>
                        </tr>
                    </thead>
                    <tbody>
                        <br>
                        @foreach($students as $data)
                        <tr>
                            <td class="student" align = "left" style = "width:150px;">{{ $data->user->name }}</td>
                            <td class="adviser" align = "left" style = "width:150px; ">
                                {{ $data->researchPaper->adviser->name }}</td>
                            <td class="degree" align = "left" style = "width:150px; text-align:center">{{ $data->user->degree_type }}
                            </td>
                            <td class="amount" align = "left" style = "width:120px; text-align:center">{{ $data->amount }}</td>
                            <td class="reference" align = "left" style = "width:120px; text-align:center">
                                {{ $data->reference_number }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </u>
        </strong>
    </div>

    <br>


    <div id ="table4" style = "border: 1px solid black;font-size:12px;font-family:Sans-serif;">
        <strong>
            <table>
                <tr class="tabletitle">
                    <td class="total" align = "left" style = "width:200px;">Total Payment Made by Students</td>
                    <td class="adviser" align = "right" style = "width:300px;"> {{ $studentTotalAmount }}</td>
                    <!--amount should be displayed here-->
                </tr>
            </table>
        </strong>
    </div>

    <p style = "font-size:10px;font-family:Sans-serif;"><i>*Please see attached receipts. Thank you*</i></p>

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
