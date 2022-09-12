import { StatusBar } from 'expo-status-bar';
import { Button,StyleSheet, Text, View ,ScrollView} from 'react-native';
import { TextInput } from 'react-native-paper';


export function useFormState(useState,defaultState) {
  const [o, setO] = useState(defaultState?defaultState:{});
  const [e, setE] = useState({});

  const handleChange = (name, v) => {
    if (name.target) {
      v = name;
      name = name.target.name || name.target.id;
    }
    var vv = v && v.target ? (v.target.type === 'checkbox' ? v.target.checked : v.target.value) : v;
    setO(o => ({
      ...o, [name]: vv
    }));
    setE(e => ({
      ...e, [name]: !vv
    }));
  };
  const onfocusout = (e) => {
    const el = e.target;
    setE(e => ({
      ...e, [el.name]: !el.value
    }));
  };
  const defaultProps = function (name) {
    return {
      name: name,
      onBlur: onfocusout,
      error: e[name],
      required: true,
      value: o[name],
      onChange: handleChange
    }
  }

  const bindEvents = function (form) {
    var list = form.querySelectorAll("input");
    for (let item of list) {
      item.addEventListener('focusout', onfocusout);
      //item.addEventListener('input', handleChange);
    }
    return () => {
      for (let item of list) {
        item.removeEventListener('focusout', onfocusout);
        //item.removeEventListener('input', handleChange);
      }
    }
  }

  const validate = function (form) {
    let ok = true;
    let list = form.querySelectorAll("input");
    for (let item of list) {
      if (!item.value) {
        setE(e => ({
          ...e, [item.name]: !item.value
        }));
        ok = false;
      }
    }
    return ok;
  }

  return [
    o,
    { defaultProps, handleChange, bindEvents, validate }
  ];
}




export default function App() {
	const [o, setO] = useFormState(React.useState);
	

  return (
    <ScrollView style={styles.container}>
      <Text>Open up App.js to start working on your app!</Text>
      <StatusBar style="auto" />
	  <TextInput
      label="Codigo"
      ...defaultProps('code')
    />
	<TextInput
      label="Nombre Completo"
      ...defaultProps('fullName')
    />
	<TextInput
      label="Email"
      ...defaultProps('email')
    />
	  <Button
  onPress={onPressLearnMore}
  title="Learn More"
  color="#841584"
  accessibilityLabel="Learn more about this purple button"
/>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
