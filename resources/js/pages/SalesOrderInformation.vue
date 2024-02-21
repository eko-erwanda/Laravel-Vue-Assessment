<script setup>
//  import { BTableSimple, BThead, BTr } from 'bootstrap';

</script>
<template>
    <BTableSimple responsive stripped>
        <BThead>
          <BTr>
            <BTh>No</BTh>
            <BTh>Sales Order Number</BTh>
            <BTh>Customer</BTh>
            <BTh>Date</BTh>
            <BTh>Total Order</BTh>
            <BTh>Action</BTh>
          </BTr>
        </BThead>
        <BTbody>
          <BTr>
            <BTh>1</BTh>
            <BTd>SO123001</BTd>
            <BTd>Michael</BTd>
            <BTd>23/12/2023</BTd>
            <BTd>100</BTd>
            <BTd>
                <BButtonGroup size="sm">
                    <BButton variant="warning">Edit</BButton>
                    <BButton variant="danger">Delete</BButton>
                    <BButton variant="info">Detail</BButton>
                </BButtonGroup>
            </BTd>
          </BTr>
        </BTbody>
    </BTableSimple>
</template>
