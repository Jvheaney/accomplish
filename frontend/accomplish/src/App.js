import { View } from "react-native"
import TodoList from './scenes/TodoList';

function App() {
  return (
    <View style={{height: '100%', width: '100%', backgroundColor: "#80C904"}}>
      <TodoList></TodoList>
    </View>
  );
}

export default App;
