<script setup>
import TicketInput from './TicketInput.vue'
import TicketTextArea from './TicketTextArea.vue'
</script>

<script>
export default {
  data(){
    return {
      inputs: {
        model: 'Ticket',
        storage: 'file',
        name: '',
        phone: '',
        message: ''
      },
      alert: {
        messages: {},
        color: '',
        show: false,
      },
      error: false
    }
  },
  methods: {
    textInput: function ({name, value}){
      this.inputs[name] = value; 
    },
    formSubmit: function (event){
      event.preventDefault();
      for(let input in this.inputs)
        console.dir(this.inputs[input]);

      this.sendRequest('/api/newticket', this.inputs);
    },
    sendRequest: function(action, data){
      console.dir(action);
      console.dir(data.name);
      fetch('http://localhost:8000/api/newticket',  {
        method: 'POST',
        headers: {
          'Content-Type':'apllication/json'
        },
        body: JSON.stringify(data),
      })  
      .then(response=>{
        console.dir(response.ok);
        !response.ok 
          ? this.error = true
          : this.error = false;
        console.dir(this.error);
        return response.json();
      })
      .then(data=>{
        console.dir(data);
        if(this.error)
          this.showAlert(data, 'danger');
        else
          this.showAlert({message: data.name+', ваша заявка принята!'}, 'success');

      });
    },
    showAlert: function(messages, color){
      this.alert.messages = messages;
      this.alert.color = color;
      this.alert.show = true;
    }
  }
}
</script>

<template>
  <div class="col-md-7 col-lg-5 col-xl-3 mx-auto">
    <div v-if="alert.show" :class="'alert alert-'+alert.color">
      <div v-for="msgs in alert.messages">
        <div v-if="typeof msgs !== 'string'" v-for="msg in msgs">
          {{ msg }}
        </div>
        <div v-else>
          {{ msgs }}
        </div>
      </div>
    </div>
    <form @submit="formSubmit" class="d-flex flex-column">
      <TicketInput @text-input="textInput" type="text" name="name" label="Имя" :value="inputs.name.value"/>
      <TicketInput placeholder="+79998887766" @text-input="textInput" type="phone" name="phone" label="Телефон" :value="inputs.phone.value"/>
      <TicketTextArea @text-input="textInput" type="text" name="message" label="Сообщение" :value="inputs.message.value"/>
      <input class="form-control mx-auto my-3" type="submit" name="sumbit" value="Отправить"/>
    </form>
  </div>
</template>