<script setup>
import { ref } from 'vue';

const soNumber = ref('');
const customerName = ref('');
const orderDate = ref('');

const selectedStyle = ref(null);
const selectedMethod = ref(null);

const orderStyleItems = ref([]);

const modalStyle = ref(false), masterStyles = ref([
  {name:'StyleA',id:'StyleIdA',selected:false},
  {name:'StyleB',id:'StyleIdB',selected:false},
  {name:'StyleC',id:'StyleIdC',selected:false},
]), doneSelectStyle = () => {
  masterStyles.value.forEach(item=>{
    if(item.selected) {
      orderStyleItems.value.push({
        styleName:item.name,
        orderItems:[]
      });
    }
  }); masterStyles.value.forEach(item => (item.selected = false));
}, selectAllStyle = (e) => masterStyles.value.forEach(item => (item.selected = e.target.checked));

const modalColor = ref(false), masterColours = ref([
  {name:'ColourA',id:'ColourIdA',selected:false,qty:0},
  {name:'ColourB',id:'ColourIdB',selected:false,qty:0},
  {name:'ColourC',id:'ColourIdC',selected:false,qty:0},
]), doneSelectColor = () => {
  const current = {style:selectedStyle._rawValue,method:selectedMethod._rawValue};
  orderStyleItems.value.forEach((osi,i)=>{
    if(i === current.style.index) {
      if(osi.orderItems[current.method.index]) {
        osi.orderItems[current.method.index].colorItem = [];
        let totalQty = 0;
        masterColours.value.forEach(item=>{
          if(item.selected) {
            totalQty += parseInt(item.qty);
            osi.orderItems[current.method.index].colorItem.push(item);
          }
        }); osi.orderItems[current.method.index].qty = totalQty;
      }
    }
  }); masterColours.value.forEach(item => (item.selected = false));
}, selectAllColor = (e) => masterColours.value.forEach(item => (item.selected = e.target.checked));

const modalMethod = ref(false), masterMethods = ref([
  {name:'MethodA',id:'MethodIdA',selected:false},
  {name:'MethodB',id:'MethodIdB',selected:false},
  {name:'MethodC',id:'MethodIdC',selected:false},
]), doneSelectMethod = () => {
  const current = {style:selectedStyle._rawValue};
  orderStyleItems.value.forEach((osi,i)=>{
    if(i === current.style.index) {
      masterMethods.value.forEach(item=>{
        const matchOrderItems = osi.orderItems.filter(i=>(i.id===item.id));
        if(item.selected) {
          if(!matchOrderItems.length) {
            osi.orderItems.push({
              id:item.id,
              methodName:item.name,
              colorItem:[],
              qty:0,
            });
          }
        } else if(matchOrderItems.length) {
          const indexToRemove = osi.orderItems.findIndex(i => item.id === i.id);
          if(indexToRemove >= 0) osi.orderItems.splice(indexToRemove, 1);
        }
      });
    }
  }); masterMethods.value.forEach(item => (item.selected = false));
}, selectAllMethod = (e) => masterMethods.value.forEach(item => (item.selected = e.target.checked));

const handlePresetColor = (orderItem) => {
  selectedMethod.value = orderItem;
  masterColours.value.forEach(item=>{
    const selectedColor = orderItem.colorItem.filter(i=>(i.id === item.id));
    item.selected = selectedColor.length > 0;
    if(item.selected) item.qty = selectedColor[0].qty;
  });
}; const handlePresetMethod = (styleItem) => {
  selectedStyle.value = styleItem;
  masterMethods.value.forEach(item=>{
    const selectedMethod = styleItem.orderItems.filter(i=>(i.id === item.id));
    item.selected = selectedMethod.length > 0;
  });
}; const handleSubmit = () => {

}
</script>

<template>
  <BCard
    title="Sales Order Information"
    class="mt-5"
  >
    <BCardBody class="mt-4">
      <BRow class="w-25">
        <BFormInput v-model="soNumber" type="text" class="my-3" placeholder="SO Number" />
        <BFormInput v-model="customerName" type="text" class="my-3" placeholder="Customer Name" />
        <BFormInput v-model="orderDate" type="date" class="my-3" placeholder="Order Date" />
        <BButton @click="modalStyle = !modalStyle" variant="primary" class="mt-4 mb-3 w-50">Add Style</BButton>
      </BRow>

      <BRow v-for="(s, i) in orderStyleItems" :key="i" class="mb-3">
        <BCard
          :title="s.styleName"
          title-tag="h5"
          :subtitle="`QTY: ${s.orderItems.reduce((a,c)=>(a+c.qty),0)}`"
          subtitle-tag="p"
          @click="handlePresetMethod({...s,index:i})"
        >
          <BTableSimple class="mt-4" responsive stripped>
            <BThead>
              <BTr>
                <BTh>No</BTh>
                <BTh>Method Name</BTh>
                <BTh>ColorName</BTh>
                <BTh>Qty</BTh>
              </BTr>
            </BThead>
            <BTbody>
              <BTr v-for="(item, ii) in s.orderItems" :key="ii">
                <BTh>{{ii+1}}</BTh>
                <BTd>{{item.methodName}}</BTd>
                <BTd @click="handlePresetColor({...item,index:ii})">
                  <BButton @click="modalColor = !modalColor" variant="primary" class="mt-4 mb-3 w-25">{{`${item.colorItem.length?'+':''} ${item.colorItem.length} selected`}}</BButton>
                </BTd>
                <BTd>{{item.qty}}</BTd>
              </BTr>
            </BTbody>
          </BTableSimple>

          <BButton @click="modalMethod = !modalMethod" variant="primary" class="mt-4 mb-3 w-25">Add Method</BButton>
        </BCard>
      </BRow>

      <div class="d-flex justify-content-end">
        <BButton @click="handleSubmit" variant="primary" class="mt-4 mb-3 w-25 float-right" :disabled="(orderStyleItems?.length < 1)">Save</BButton>
      </div>
    </BCardBody>
  </BCard>

  <BModal v-model="modalStyle" @ok="doneSelectStyle" title="Style">
    <BTableSimple class="mt-4" responsive stripped>
      <BThead>
        <BTr>
          <BTh>
            <BFormCheckbox
              id="checkAllStyle"
              name="checkAllStyle"
              @change="selectAllStyle"
            />
          </BTh>
          <BTh>Name</BTh>
        </BTr>
      </BThead>
      <BTbody>
        <BTr v-for="(s, i) in masterStyles" :key="i">
          <BTh>
            <BFormCheckbox
              :id="s.id"
              :name="`checkStyle-${s.id}`"
              v-model="s.selected"
            />
          </BTh>
          <BTd><BLabel :for="s.id">{{s.name}}</BLabel></BTd>
        </BTr>
      </BTbody>
    </BTableSimple>
  </BModal>

  <BModal v-model="modalColor" @ok="doneSelectColor" :title="`Color Name (${selectedMethod?.methodName})`">
    <BTableSimple class="mt-4" responsive stripped>
      <BThead>
        <BTr>
          <BTh>
            <BFormCheckbox
              id="checkAllStyle"
              name="checkAllStyle"
              @change="selectAllColor"
            />
          </BTh>
          <BTh>Name</BTh>
          <BTh>Qty</BTh>
        </BTr>
      </BThead>
      <BTbody>
        <BTr v-for="(c, i) in masterColours" :key="i">
          <BTh><BFormCheckbox :id="c.id" :name="`checkStyle-${c.id}`" v-model="c.selected" /></BTh>
          <BTd><BLabel :for="c.id">{{c.name}}</BLabel></BTd>
          <BTd><BFormInput v-model="c.qty" type="number" class="my-3 w-25" placeholder="Qty" :disabled="!c.selected" /></BTd>
        </BTr>
      </BTbody>
    </BTableSimple>
  </BModal>

  <BModal v-model="modalMethod" @ok="doneSelectMethod" title="Style">
    <BTableSimple class="mt-4" responsive stripped>
      <BThead>
        <BTr>
          <BTh>
            <BFormCheckbox
              id="checkAllStyle"
              name="checkAllStyle"
              @change="selectAllMethod"
            />
          </BTh>
          <BTh>Name</BTh>
        </BTr>
      </BThead>
      <BTbody>
        <BTr v-for="(m, i) in masterMethods" :key="i">
          <BTh>
            <BFormCheckbox
              :id="m.id"
              :name="`checkStyle-${m.id}`"
              v-model="m.selected"
            />
          </BTh>
          <BTd><BLabel :for="m.id">{{m.name}}</BLabel></BTd>
        </BTr>
      </BTbody>
    </BTableSimple>
  </BModal>
</template>
