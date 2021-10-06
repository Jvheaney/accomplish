import React, {Component} from 'react';
import { Text, TouchableOpacity } from 'react-native';

class AddTaskButton extends Component {

  render() {

    return (
      <TouchableOpacity activeOpacity={0.7} onPress={() => { this.props.addTask() }} style={{height: 'auto', alignItems: 'center', marginTop: 10, marginBottom: 10, paddingTop: 10, paddingBottom: 10, paddingLeft: 30, paddingRight: 30, borderRadius: 50, backgroundColor: "#66a103", borderWidth: 3, borderColor: "green", flexDirection: 'row'}}>
        <Text style={{fontSize: 30, fontFamily: "Bubblegum Sans", color:"white"}}>+ Add Task</Text>
      </TouchableOpacity>
   );
 }
}

export default AddTaskButton;
