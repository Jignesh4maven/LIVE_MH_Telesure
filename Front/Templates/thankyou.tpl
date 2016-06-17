<style>
    .thank_you_msg{
        
        text-align: center;
    }
    .thank_you_msg .title{
        color: #009bca;
        font-style: normal;
        font-size: 20pt;
        line-height: 50px;
        
    }
     .thank_you_msg .sub_text{
        color: #868686;
        font-style: normal;
        font-size: 14pt;
        
    }
     .thank_you_msg .cust_text{
        color: #CF1429;
        font-style: normal;
          line-height: 50px;
        font-size: 14pt;
        
    }
</style>
<div>
    {if $Type == "callme"}
    <div class="thank_you_msg">
        <br/><br/><br/><br/>
    <h2 class="title">Thank you for requesting an Insurance quote from MotorHappy.</h2>
    <h2 class="sub_text">One of our Insurance Partner’s Agents will be in contact with you shortly.</h2>
    {if $Msg != ""}
        <h2 class="cust_text">Please note your reference number for future reference : {$Msg}</h2>
    {/if}
    <br/><br/><br/><br/>
    </div>
    
    {/if}
    
    {if $Type == "buy"}
    <div class="thank_you_msg">
         <br/><br/><br/><br/>
    <h2 class="title">Thank you for requesting an Insurance quote from MotorHappy</h2>
    <h2 class="sub_text">One of our Insurance Partner’s Agents will be in contact with you shortly to assist in finalizing your purchase.</h2>
     {if $Msg != ""}
         <h2 class="cust_text">Please note your reference number for future reference : {$Msg}</h2>
    {/if}
    <br/><br/><br/><br/>
    </div>
    {/if}
</div>
<script>
    localStorage.clear();
</script>