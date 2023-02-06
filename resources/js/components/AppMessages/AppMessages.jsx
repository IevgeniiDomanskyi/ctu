import { useEffect, useState } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { appClearMessages } from '@/store/app'
import Snackbar from '@mui/material/Snackbar'
import Slide from '@mui/material/Slide'
import MuiAlert from '@mui/material/Alert'
import AlertTitle from '@mui/material/AlertTitle'

function SlideTransition(props) {
  return <Slide {...props} direction="left" />;
}

const AppMessages = () => {
  const { messages } = useSelector((state) => state.app)
  const dispatch = useDispatch()

  const [open, setOpen] = useState(false)
  const [currentMessage, setCurrentMessage] = useState({})

  useEffect(() => {
    if (messages.length) {
      for (const message of messages) {
        setOpen(true)
        setCurrentMessage(message)
      }
      dispatch(appClearMessages())
    }
  }, [messages])

  const handleClose = () => {
    console.log('handleClose AppMessages')
    setOpen(false)
  }

  return (
    <Snackbar
      open={open}
      autoHideDuration={6000}
      onClose={handleClose}
      TransitionComponent={SlideTransition}
      anchorOrigin={{ vertical: "top", horizontal: "right" }}      
    >
      <MuiAlert onClose={handleClose} variant="filled" severity={currentMessage.type} sx={{ width: '100%' }}>
        <AlertTitle style={{textTransform: 'capitalize'}}>{currentMessage.type}</AlertTitle>
        { currentMessage.text }
      </MuiAlert>
    </Snackbar> 
  );
}

export default AppMessages;