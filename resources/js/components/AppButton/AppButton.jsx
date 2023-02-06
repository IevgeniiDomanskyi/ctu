import Button from '@mui/material/Button'

const AppButton = ({children, onClick, variant = 'contained', color = 'secondary', ...props}) => {
  return (
    <Button
      variant={variant}
      color={color}
      onClick={() => onClick()}
      {...props}
    >
      { children }
    </Button>
  )
}

export default AppButton