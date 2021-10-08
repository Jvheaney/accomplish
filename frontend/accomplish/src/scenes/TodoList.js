import React, {Component} from "react"
import { ScrollView, View } from "react-native"

import { apiCall } from '../utilities/Networking';

import Container from '../elements/Container';
import Title from '../components/Title';
import TodoItem from '../components/TodoItem';
import AddTaskButton from '../components/AddTaskButton';
import ToggleEditingButton from '../components/ToggleEditingButton';

class TodoList extends Component {

  state = {
    tasks: [],
    isEditing: false
  }

  componentDidMount() {
    this.getTasks();
  }

  getTasks = async () => {
    const tasks = await apiCall("getTasks.php", {"token": window.token});
    this.setState({
      tasks: (!Array.isArray(tasks.data))?[]:tasks.data
    });
  }

  toggleTask = async (taskId, isCompleted) => {
    if(isCompleted){
      //we want to undo the task
      await apiCall("undoTask.php", {"token": window.token, "taskId": taskId});
    }
    else{
      //We want to complete the task
      //Send to database
      await apiCall("completeTask.php", {"token": window.token, "taskId": taskId});
    }
    var tasks_copy = this.state.tasks;
    for(var i=0; i<tasks_copy.length; i++){
      if(tasks_copy[i]['task_id'] === taskId){
        tasks_copy[i]['completed'] = !isCompleted;
        break;
      }
    }
    this.setState({
      tasks: tasks_copy
    });
  }

  removeTask = async (taskId) => {
    await apiCall("removeTask.php", {"token": window.token, "taskId": taskId});

    var tasks_copy = this.state.tasks;
    for(var i=0; i<tasks_copy.length; i++){
      if(tasks_copy[i]['task_id'] === taskId){
        tasks_copy.splice(i,1);
        break;
      }
    }
    this.setState({
      tasks: tasks_copy
    });
  }

  addTask = () => {
    var tasks_copy = this.state.tasks;
    if(tasks_copy[tasks_copy.length-1].editingTask == true){
      return;
    }
    tasks_copy.push({task_id: -1, completed: false, editingTask: true, task_name: ""});
    this.setState({
      tasks: tasks_copy
    });
  }

  saveTask = async (taskName) => {
    var addedTask = await apiCall("addTask.php", {"token": window.token, "taskName": taskName});
    var tasks_copy = this.state.tasks;
    tasks_copy.splice(tasks_copy.length-1, 1, {task_id: addedTask.data, completed: false, task_name: taskName});
    this.setState({
      tasks: tasks_copy
    });
  }

  renderTasks = () => {
    return this.state.tasks.map((task) => {
      return(
        <TodoItem
          key={"task_" + task.task_id}
          taskId={task.task_id}
          taskName={task.task_name}
          checked={(task.completed === true || task.completed === "t")}
          toggleTask={() => this.toggleTask(task.task_id, (task.completed === true || task.completed === "t"))}
          removeTask={() => this.removeTask(task.task_id)}
          saveTask={(input) => this.saveTask(input)}
          isEditing={this.state.isEditing}
          editingTask={(task.editingTask !== undefined)}
          >
        </TodoItem>
      )
    })
  }

  finishEditing = () => {
    var tasks_copy = this.state.tasks;
    if(tasks_copy[tasks_copy.length-1].editingTask == true){
      tasks_copy.pop();
      this.setState({
        tasks: tasks_copy
      })
    }
    this.setState({isEditing: !this.state.isEditing});
  }

  render() {
    console.disableYellowBox = true;

    return (
      <Container>
        <ScrollView showsVerticalScrollIndicator={false} style={{height: 'auto', width: '100%'}}>
          <View style={{width: '100%', height: '100%', alignItems: 'center'}}>
            <View style={{height: 'auto', width: '100%', maxWidth: 510, padding: 10}}>
              <View style={{height: 'auto', width: '100%', alignItems: "center", justifyContent: "center"}}>
                <Title></Title>
                <ToggleEditingButton
                  isEditing={this.state.isEditing}
                  toggleEditing={() => this.finishEditing()}
                  ></ToggleEditingButton>
                <View style={{width: 'auto'}}>
                  {this.renderTasks()}
                </View>
                {
                  (this.state.isEditing)?
                  <AddTaskButton
                    addTask={() => this.addTask()}
                    >
                  </AddTaskButton>
                  :
                  <View></View>
                }
              </View>
            </View>
          </View>
        </ScrollView>
      </Container>
   );
 }
}

export default TodoList;
